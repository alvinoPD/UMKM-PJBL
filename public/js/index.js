document.addEventListener('alpine:init', () => {
            Alpine.data('warung', (produk, badgeStyles) => ({
                produk,
                badgeStyles,
 
                // UI
                mobileMenuOpen: false,
                kategoriAktif: 'semua',
                cartOpen: false,
 
                // Modal detail produk
                modalBuka: false,
                produkDipilih: null,
                porsiIndex: 0,
                jumlah: 1,
 
                // Keranjang: [{ key, id, nama, gambar, porsi, harga (satuan, sudah termasuk tambahan porsi), qty }]
                keranjang: [],
 
                // Checkout & pembayaran
                openCheckout: false,
                step: 1,                 // 1 = Pesanan, 2 = Pembayaran, 3 = Bayar
                selectedPayment: 'ovo',
                notes: '',
                timer: 120,              // detik
                timerId: null,
                notif: '',
                notifId: null,
                langkah: [
                    { n: 1, label: 'Pesanan', judul: 'Ringkasan Pesanan' },
                    { n: 2, label: 'Pembayaran', judul: 'Pilih Pembayaran' },
                    { n: 3, label: 'Bayar', judul: 'Selesaikan Pembayaran' },
                ],
                // tipe: 'qr' | 'va' | 'kasir' -> menentukan tampilan di langkah 3. Di produksi biasanya datang dari config/API.
                metodeBayar: [
                    { id: 'dana', nama: 'DANA', deskripsi: 'Dompet digital DANA', icon: '💙', tipe: 'qr' },
                    { id: 'gopay', nama: 'GoPay', deskripsi: 'Dompet GoPay Gojek', icon: '💚', tipe: 'qr' },
                    { id: 'ovo', nama: 'OVO', deskripsi: 'Dompet OVO', icon: '💜', tipe: 'qr' },
                    { id: 'bca', nama: 'BCA Virtual Account', deskripsi: 'Transfer bank BCA', icon: '🔵', tipe: 'va', prefix: '39358' },
                    { id: 'mandiri', nama: 'Mandiri Virtual Account', deskripsi: 'Transfer bank Mandiri', icon: '🟡', tipe: 'va', prefix: '88608' },
                    { id: 'bni', nama: 'BNI Virtual Account', deskripsi: 'Transfer bank BNI', icon: '🟠', tipe: 'va', prefix: '8848' },
                    { id: 'kasir', nama: 'Bayar di Kasir', deskripsi: 'Tunjukkan bukti ke kasir', icon: '💵', tipe: 'kasir' },
                ],
 
                init() {
                    // Timer dikelola lewat $watch, jadi berlaku berapa pun cara `step` berubah
                    // (tombol, klik stepper, dll) dan interval tidak pernah bocor.
                    this.$watch('step', (v) => {
                        if (v === 3) this.mulaiTimer(); else this.hentikanTimer();
                        this.$nextTick(() => { if (this.$refs.checkoutBody) this.$refs.checkoutBody.scrollTop = 0; });
                    });
                    this.$watch('openCheckout', (buka) => { if (!buka) this.hentikanTimer(); });
                },
 
                // ----- nilai turunan (getter = otomatis reaktif) -----
                get totalKeranjang() {
                    return this.keranjang.reduce((n, i) => n + i.qty, 0);
                },
                get totalHarga() {
                    return this.keranjang.reduce((n, i) => n + i.harga * i.qty, 0);
                },
                get porsiDipilih() {
                    const p = this.produkDipilih;
                    return p && p.porsi.length ? p.porsi[this.porsiIndex] : null;
                },
                get hargaSatuanModal() {
                    if (!this.produkDipilih) return 0;
                    return this.produkDipilih.harga + (this.porsiDipilih ? this.porsiDipilih.tambahan : 0);
                },
                get totalModal() {
                    return this.hargaSatuanModal * this.jumlah;
                },
 
                get metodeAktif() {
                    return this.metodeBayar.find(m => m.id === this.selectedPayment) ?? null;
                },
                get timerTeks() { // 112 -> "1:52"
                    return Math.floor(this.timer / 60) + ':' + String(this.timer % 60).padStart(2, '0');
                },
                get kedaluwarsa() {
                    return this.timer <= 0;
                },
                get nomorVA() { // nomor contoh; di produksi dibuat gateway
                    const m = this.metodeAktif;
                    if (!m || m.tipe !== 'va') return '';
                    return (m.prefix + '0007' + String(this.totalHarga).padStart(8, '0')).replace(/(.{4})/g, '$1 ').trim();
                },
                get kodePesanan() {
                    return 'BI-07-' + String(this.totalHarga).padStart(6, '0');
                },
                // Pola QR palsu 21x21 (3 penanda sudut + modul acak deterministik). Satu <path> saja,
                // karena <template x-for> tidak jalan di dalam <svg>.
                get qrPath() {
                    const n = 21, sudut = [[0, 0], [n - 7, 0], [0, n - 7]];
                    let seed = (this.totalHarga % 9973) + 7;
                    const acak = () => { seed = (seed * 16807) % 2147483647; return seed / 2147483647; };
                    let d = '';
                    for (let y = 0; y < n; y++) {
                        for (let x = 0; x < n; x++) {
                            const z = sudut.find(([fx, fy]) => x >= fx - 1 && x <= fx + 7 && y >= fy - 1 && y <= fy + 7);
                            let isi;
                            if (z) {
                                const dx = x - z[0], dy = y - z[1];
                                if (dx < 0 || dx > 6 || dy < 0 || dy > 6) continue; // jarak putih di sekitar penanda
                                isi = dx === 0 || dx === 6 || dy === 0 || dy === 6 || (dx >= 2 && dx <= 4 && dy >= 2 && dy <= 4);
                            } else {
                                isi = acak() > 0.5;
                            }
                            if (isi) d += 'M' + x + ' ' + y + 'h1v1h-1z';
                        }
                    }
                    return d;
                },
 
                rupiah(angka) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
                },
 
                // ----- modal -----
                bukaModal(id) {
                    const p = this.produk.find(x => x.id === id);
                    if (!p || p.stokHabis) return;
                    this.produkDipilih = p;
                    this.porsiIndex = 0;
                    this.jumlah = 1;
                    this.modalBuka = true;
                },
                tutupModal() {
                    this.modalBuka = false;
                },
 
                // ----- keranjang -----
                tambahKeKeranjang() {
                    if (!this.produkDipilih) return;
                    this.masukKeranjang(this.produkDipilih, this.porsiDipilih, this.jumlah);
                    this.tutupModal();
                },
                tambahCepat(id) { // tombol "+" di card: porsi pertama, jumlah 1
                    const p = this.produk.find(x => x.id === id);
                    if (!p || p.stokHabis) return;
                    this.masukKeranjang(p, p.porsi[0] ?? null, 1);
                },
                masukKeranjang(p, porsi, qty) {
                    // Produk sama + porsi beda = baris berbeda; produk sama + porsi sama = qty digabung.
                    const key = p.id + '-' + (porsi ? porsi.nama : 'default');
                    const ada = this.keranjang.find(i => i.key === key);
                    if (ada) {
                        ada.qty += qty;
                    } else {
                        this.keranjang.push({
                            key, id: p.id, nama: p.nama, gambar: p.gambar,
                            porsi: porsi ? porsi.nama : null,
                            harga: p.harga + (porsi ? porsi.tambahan : 0),
                            qty,
                        });
                    }
                },
                ubahQty(key, delta) {
                    const item = this.keranjang.find(i => i.key === key);
                    if (!item) return;
                    item.qty += delta;
                    if (item.qty <= 0) this.hapus(key);
                },
                hapus(key) {
                    this.keranjang = this.keranjang.filter(i => i.key !== key);
                },
 
                // ----- checkout -----
                bukaCheckout() {
                    if (!this.keranjang.length) return;
                    this.cartOpen = false;
                    this.step = 1;          // selalu mulai dari awal; catatan (notes) dipertahankan
                    this.openCheckout = true;
                },
                tutupCheckout() {
                    this.openCheckout = false;
                },
                mulaiTimer() {
                    this.hentikanTimer();
                    this.timer = 120;
                    this.timerId = setInterval(() => {
                        if (this.timer > 0) this.timer--; else this.hentikanTimer();
                    }, 1000);
                },
                hentikanTimer() {
                    clearInterval(this.timerId);
                    this.timerId = null;
                },
                selesaiBayar() {
                    // TODO: kirim pesanan (produk + catatan + metode) ke backend, lalu tunggu konfirmasi lunas via webhook.
                    this.keranjang = [];
                    this.notes = '';
                    this.openCheckout = false;
                    this.tampilNotif('Terima kasih! Pesanan Meja 7 sedang diteruskan ke dapur.');
                },
                tampilNotif(pesan) {
                    this.notif = pesan;
                    clearTimeout(this.notifId);
                    this.notifId = setTimeout(() => { this.notif = ''; }, 4000);
                },
            }));
        });