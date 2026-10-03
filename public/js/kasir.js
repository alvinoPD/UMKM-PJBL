tailwind.config = {
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] }
        }
    }
}
/* Logika Panel POS */
function posApp() {
    return {
        category: 'semua',
        orderType: 'meja',
        tableNo: 1,
        customerName: '',
        payment: 'Tunai',
        cart: [],
        toast: '',
        toastTimer: null,
        categories: [
            { key: 'semua', label: 'Semua' },
            { key: 'makanan', label: 'Makanan' },
            { key: 'minuman', label: 'Minuman' },
            { key: 'tambahan', label: 'Tambahan' }
        ],
        payments: ['Tunai', 'QRIS', 'DANA', 'GoPay', 'OVO', 'BCA', 'Mandiri'],
        menu: [
            { id: 1, name: 'Bebek Goreng Bumbu Ireng', price: 22000, category: 'makanan', label: 'Best Seller', available: true, emoji: '🍗', img: '/img/menu/bebek-goreng-bumbu-ireng.jpg' },
            { id: 2, name: 'Bebek Bakar Kremes Madura', price: 24000, category: 'makanan', label: 'Rekomendasi', available: true, emoji: '🍗', img: '/img/menu/bebek-bakar-kremes.jpg' },
            { id: 3, name: 'Sate Ampela Ati Bumbu Ireng', price: 8000, category: 'tambahan', label: '', available: true, emoji: '🍡', img: '/img/menu/sate-ampela-ati.jpg' },
            { id: 4, name: 'Es Teh Manis Jumbo', price: 5000, category: 'minuman', label: '', available: true, emoji: '🥤', img: '/img/menu/es-teh-manis.jpg' },
            { id: 5, name: 'Es Jeruk Peras Murni', price: 7000, category: 'minuman', label: '', available: false, emoji: '🍹', img: '/img/menu/es-jeruk-peras.jpg' },
            { id: 6, name: 'Ayam Goreng Sambal Korek', price: 20000, category: 'makanan', label: 'Pedas', available: true, emoji: '🍗', img: '/img/menu/ayam-goreng-sambal-korek.jpg' }
        ],
        get filtered() {
            return this.category === 'semua'
                ? this.menu
                : this.menu.filter(m => m.category === this.category);
        },
        get availableCount() {
            return this.filtered.filter(m => m.available).length;
        },
        get itemCount() {
            return this.cart.reduce((sum, i) => sum + i.qty, 0);
        },
        get total() {
            return this.cart.reduce((sum, i) => sum + i.price * i.qty, 0);
        },
        rp(n) {
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        },
        qtyOf(id) {
            const found = this.cart.find(i => i.id === id);
            return found ? found.qty : 0;
        },
        add(m) {
            if (!m.available) return;
            const found = this.cart.find(i => i.id === m.id);
            if (found) { found.qty++; }
            else { this.cart.push({ id: m.id, name: m.name, price: m.price, emoji: m.emoji, img: m.img, qty: 1 }); }
        },
        inc(item) { item.qty++; },
        dec(item) {
            item.qty--;
            if (item.qty <= 0) this.remove(item);
        },
        remove(item) {
            this.cart = this.cart.filter(i => i.id !== item.id);
        },
        tableDec() { if (this.tableNo > 1) this.tableNo--; },
        tableInc() { this.tableNo++; },
        showToast(msg) {
            this.toast = msg;
            clearTimeout(this.toastTimer);
            this.toastTimer = setTimeout(() => this.toast = '', 3000);
        },
        checkout() {
            if (this.cart.length === 0) return;
            const tujuan = this.orderType === 'meja' ? 'Meja ' + this.tableNo : 'Takeaway';
            this.showToast('Pesanan ' + tujuan + ' diproses via ' + this.payment + ' · ' + this.rp(this.total));
            this.cart = [];
            this.customerName = '';
        }
    }
}

/* Logika Panel Monitor Pesanan */
function monitorApp() {
    return {
        activeFilter: 'Semua',
        filters: ['Semua', 'Antri', 'Dimasak', 'Siap', 'Selesai'],
        orders: [
            { id: 'BI-053', table: 'Meja 7', status: 'Antri', items: ['1× Bebek Bakar Kremes'], price: 'Rp 24.000', payment: 'OVO • 1j lalu', note: null },
            { id: 'BI-041', table: 'Meja 3', status: 'Dimasak', items: ['2× Bebek Goreng Bumbu', '2× Es Teh Manis'], price: 'Rp 54.000', payment: 'QRIS • 1j lalu', note: null },
            { id: 'BI-042', table: 'Meja 5', status: 'Antri', items: ['1× Bebek Bakar Kremes', '2× Sate Ampela Ati'], price: 'Rp 48.000', payment: 'DANA • 1j lalu', note: 'Bebeknya minta extra matang' },
            { id: 'BI-043', table: 'Meja 1', status: 'Siap', items: ['3× Bebek Goreng Bumbu'], price: 'Rp 66.000', payment: 'GoPay • 1j lalu', note: null },
            { id: 'BI-044', table: 'Meja 8', status: 'Selesai', items: ['1× Ayam Goreng Sambal', '1× Es Teh Manis'], price: 'Rp 25.000', payment: 'OVO • 1j lalu', note: null }
        ],
        get filteredOrders() {
            if (this.activeFilter === 'Semua') return this.orders;
            return this.orders.filter(o => o.status === this.activeFilter);
        },
        getCount(status) {
            if (status === 'Semua') return this.orders.length;
            return this.orders.filter(o => o.status === status).length;
        },
        nextStatus(order) {
            if (order.status === 'Antri') order.status = 'Dimasak';
            else if (order.status === 'Dimasak') order.status = 'Siap';
            else if (order.status === 'Siap') order.status = 'Selesai';
        },
        getCardTheme(status) {
            const themes = {
                'Antri': 'border-[#d97706] bg-[#1a140a]',
                'Dimasak': 'border-[#2563eb] bg-[#0a1120]',
                'Siap': 'border-[#16a34a] bg-[#0a1710]',
                'Selesai': 'border-[#374151] bg-[#111111]'
            };
            return themes[status] || themes['Antri'];
        },
        getStatusBadgeStyle(status) {
            const styles = {
                'Antri': 'border border-[#d97706] text-[#d97706]',
                'Dimasak': 'bg-[#1e3a8a]/50 border border-[#2563eb]/30 text-[#60a5fa]',
                'Siap': 'bg-[#14532d]/50 border border-[#16a34a]/30 text-[#4ade80]',
                'Selesai': 'bg-[#1f2937] text-[#9ca3af]'
            };
            return styles[status] || '';
        },
        getButtonConfig(status) {
            const configs = {
                'Antri': { text: 'Mulai Masak →', class: 'border border-[#4b5563] hover:border-[#9ca3af] text-gray-300' },
                'Dimasak': { text: 'Tandai Siap ✓', class: 'border border-[#16a34a] text-[#4ade80] hover:bg-[#16a34a]/20' },
                'Siap': { text: 'Selesai', class: 'bg-[#1f2937] text-gray-400 hover:bg-[#374151] border border-transparent' },
                'Selesai': { text: 'Selesai', class: 'hidden' }
            };
            return configs[status] || configs['Antri'];
        }
    }
}