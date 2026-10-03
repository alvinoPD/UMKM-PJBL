<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bumbu Ireng — Warung Bebek Bumbu Ireng</title>
 
   <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
 
    {{-- x-cloak mencegah elemen ber-x-show "berkedip" sebelum Alpine siap --}}
    <style>[x-cloak]{ display: none !important; }</style>
</head>
<body class="min-h-screen bg-[#121212] font-sans text-gray-100 antialiased"
    x-data="warung(@js($produk), @js($badgeStyles))"
    @keydown.escape.window="modalBuka = false; cartOpen = false; openCheckout = false"
    {{-- kunci scroll halaman saat modal terbuka, atau saat drawer keranjang terbuka di layar < 1280px --}}
    x-effect="document.body.classList.toggle('overflow-hidden', modalBuka || openCheckout || (cartOpen && window.matchMedia('(max-width: 1279px)').matches))">
 
    {{-- ============ NAVBAR ============ --}}
    <header class="sticky top-0 z-50 border-b border-white/5 bg-[#121212]/95 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
 
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex shrink-0 items-center gap-2">
                <span class="text-2xl leading-none">🦆</span>
                <span class="text-xl font-extrabold tracking-tight text-[#ff6b00]">Bebek Protol</span>
            </a>
 
            {{-- Badge status buka — disembunyikan di layar paling kecil biar navbar tidak sesak --}}
            <span class="hidden items-center gap-1.5 rounded-full bg-green-500/10 px-3 py-1 text-xs font-medium text-green-400 sm:inline-flex">
                <span class="h-1.5 w-1.5 rounded-full bg-green-400"></span>
                Buka · 10:00–22:00
            </span>
 
            {{-- Nav links (desktop) --}}
            <nav class="hidden items-center gap-8 text-sm font-medium lg:flex">
                <button type="button" @click="kategoriAktif = 'semua'" :class="kategoriAktif === 'semua' ? 'text-[#ff6b00]' : 'text-gray-400 hover:text-white'" class="transition">Semua</button>
                <button type="button" @click="kategoriAktif = 'makanan'" :class="kategoriAktif === 'makanan' ? 'text-[#ff6b00]' : 'text-gray-400 hover:text-white'" class="transition">Makanan</button>
                <button type="button" @click="kategoriAktif = 'minuman'" :class="kategoriAktif === 'minuman' ? 'text-[#ff6b00]' : 'text-gray-400 hover:text-white'" class="transition">Minuman</button>
                <button type="button" @click="kategoriAktif = 'tambahan'" :class="kategoriAktif === 'tambahan' ? 'text-[#ff6b00]' : 'text-gray-400 hover:text-white'" class="transition">Tambahan</button>
            </nav>
 
            {{-- Aksi kanan (desktop) --}}
            <div class="hidden items-center gap-3 lg:flex">
                <button type="button"
                    class="flex items-center gap-1.5 whitespace-nowrap rounded-full border border-[#ff6b00]/40 bg-[#ff6b00]/10 px-4 py-2 text-sm font-semibold text-[#ff6b00] transition hover:bg-[#ff6b00]/20">
                    🪑 Meja 7
                </button>
                <button type="button"
                    @click="cartOpen = true"
                    class="relative flex items-center gap-2 whitespace-nowrap rounded-lg border border-white/10 bg-[#1e1e1e] px-4 py-2 text-sm font-semibold text-gray-200 transition hover:border-white/20 hover:bg-[#242424]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m-10 0a2 2 0 104 0m6 0a2 2 0 104 0" />
                    </svg>
                    Keranjang
                    <span x-show="totalKeranjang > 0" x-cloak x-text="totalKeranjang"
                        class="absolute -right-2 -top-2 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-[#ff6b00] px-1 text-[11px] font-bold text-white"></span>
                </button>
            </div>
 
            {{-- Tombol hamburger (mobile) --}}
            <button type="button" class="lg:hidden" @click="mobileMenuOpen = !mobileMenuOpen"
                :aria-expanded="mobileMenuOpen" aria-label="Buka menu navigasi">
                <svg class="h-6 w-6 text-gray-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
 
        {{-- Panel menu mobile --}}
        <div x-show="mobileMenuOpen" x-cloak x-transition.duration.150ms
            class="border-t border-white/5 px-4 pb-5 lg:hidden">
            <div class="flex flex-col gap-4 pt-4 text-sm font-medium">
                <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-green-500/10 px-3 py-1 text-xs font-medium text-green-400">
                    <span class="h-1.5 w-1.5 rounded-full bg-green-400"></span>
                    Buka · 10:00–22:00
                </span>
 
                <div class="flex flex-col gap-3 text-left">
                    <button type="button" @click="kategoriAktif = 'semua'; mobileMenuOpen = false" :class="kategoriAktif === 'semua' ? 'text-[#ff6b00]' : 'text-gray-400'">Semua</button>
                    <button type="button" @click="kategoriAktif = 'makanan'; mobileMenuOpen = false" :class="kategoriAktif === 'makanan' ? 'text-[#ff6b00]' : 'text-gray-400'">Makanan</button>
                    <button type="button" @click="kategoriAktif = 'minuman'; mobileMenuOpen = false" :class="kategoriAktif === 'minuman' ? 'text-[#ff6b00]' : 'text-gray-400'">Minuman</button>
                    <button type="button" @click="kategoriAktif = 'tambahan'; mobileMenuOpen = false" :class="kategoriAktif === 'tambahan' ? 'text-[#ff6b00]' : 'text-gray-400'">Tambahan</button>
                </div>
 
                <div class="mt-1 flex gap-3">
                    <button type="button" class="flex-1 rounded-full border border-[#ff6b00]/40 bg-[#ff6b00]/10 px-4 py-2 text-sm font-semibold text-[#ff6b00]">
                        🪑 Meja 7
                    </button>
                    <button type="button" @click="cartOpen = true; mobileMenuOpen = false" class="relative flex-1 rounded-lg border border-white/10 bg-[#1e1e1e] px-4 py-2 text-sm font-semibold text-gray-200">
                        🛒 Keranjang
                        <span x-show="totalKeranjang > 0" x-cloak x-text="totalKeranjang"
                            class="absolute -right-1.5 -top-1.5 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-[#ff6b00] px-1 text-[11px] font-bold text-white"></span>
                    </button>
                </div>
            </div>
        </div>
    </header>
 
    {{-- ============ AREA UTAMA + PANEL KERANJANG (kolom kanan di >= xl) ============ --}}
    <div class="xl:flex">
 
        {{-- ============ HERO BANNER PROMO ============ --}}
        <main class="min-w-0 flex-1">
            <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-16">
                <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
 
                    {{-- Kiri: copy promo + CTA --}}
                    <div>
                        <div class="mb-5 flex items-center gap-2">
                            <span class="h-4 w-1 rounded-full bg-[#ff6b00]"></span>
                            <span class="text-xs font-semibold uppercase tracking-widest text-[#ff6b00]">
                                Promo Spesial Hari Ini
                            </span>
                        </div>
 
                        <h1 class="text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-6xl">
                            Paket Nasi Bebek<br>
                            + Es Teh
                        </h1>
 
                        <p class="mt-4 text-4xl font-extrabold text-[#ff6b00] sm:text-5xl">
                            Rp 25.000
                        </p>
 
                        <p class="mt-5 max-w-md text-base leading-relaxed text-gray-400">
                            Kenikmatan bebek goreng Madura legendaris, dipesan langsung dari meja kamu.
                        </p>
 
                        <button type="button"
                            class="mt-8 inline-flex items-center gap-2 rounded-full bg-[#ff6b00] px-8 py-4 text-base font-bold text-white shadow-lg shadow-[#ff6b00]/20 transition hover:brightness-110 active:scale-[0.98]">
                            Pesan Sekarang
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
 
                    {{-- Kanan: gambar hero --}}
                    <div class="relative order-first lg:order-last">
                        <div class="relative aspect-[4/3] overflow-hidden rounded-3xl bg-[#1e1e1e] sm:aspect-[16/10] lg:aspect-[4/3]">
                            {{-- Ganti src ini dengan foto produk asli, taruh di public/images/hero/ --}}
                            <img
                                src="{{ asset('images/hero/paket-nasi-bebek.jpg') }}"
                                alt="Paket Nasi Bebek dan Es Teh"
                                class="h-full w-full object-cover"
                            >
 
                            {{-- Gradien halus di sisi kiri gambar supaya "menyatu" dengan background,
                                 meniru efek di desain referensi. Disembunyikan di mobile karena
                                 gambar full-width tidak butuh transisi ini. --}}
                            <div class="pointer-events-none absolute inset-y-0 left-0 hidden w-1/3 bg-gradient-to-r from-[#121212] to-transparent lg:block"></div>
                        </div>
                    </div>
 
                </div>
            </section>
 
            {{-- ============ SIDEBAR KATEGORI/INFO + GRID PRODUK ============ --}}
            <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[240px_1fr]">
 
                    {{-- ---------- SIDEBAR KIRI ---------- --}}
                    <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
 
                        {{-- Kategori --}}
                        <div>
                            <h2 class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-500">Kategori</h2>
                            <nav class="space-y-1.5">
                                @foreach ([
                                    'semua' => ['label' => 'Semua', 'icon' => '🍱'],
                                    'makanan' => ['label' => 'Makanan', 'icon' => '🦆'],
                                    'minuman' => ['label' => 'Minuman', 'icon' => '🧊'],
                                    'tambahan' => ['label' => 'Tambahan', 'icon' => '🧂'],
                                ] as $slug => $kategori)
                                    <button type="button" @click="kategoriAktif = '{{ $slug }}'"
                                        :class="kategoriAktif === '{{ $slug }}'
                                            ? 'border-[#ff6b00] bg-[#ff6b00]/10 text-[#ff6b00]'
                                            : 'border-transparent text-gray-400 hover:bg-white/5 hover:text-gray-200'"
                                        class="flex w-full items-center gap-2.5 rounded-lg border px-3 py-2.5 text-sm font-medium transition">
                                        <span>{{ $kategori['icon'] }}</span>
                                        {{ $kategori['label'] }}
                                    </button>
                                @endforeach
                            </nav>
                        </div>
 
                        {{-- Info Warung --}}
                        <div class="rounded-2xl border border-white/5 bg-[#1e1e1e] p-4">
                            <h2 class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-500">Info Warung</h2>
                            <div class="space-y-3 text-sm text-gray-300">
                                <div class="flex items-start gap-2.5">
                                    <span class="mt-0.5">📍</span>
                                    <span>Taman bungkul, Surabaya</span>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <span class="mt-0.5">🕐</span>
                                    <span>10:00 – 22:00 WIB</span>
                                </div>
                            </div>
                        </div>
                    </aside>
 
                    {{-- ---------- GRID KONTEN KANAN ---------- --}}
                    <div>
                        {{-- Header: judul + sortir --}}
                        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                            <h2 class="text-xl font-bold text-white sm:text-2xl">
                                Semua Menu
                                <span class="font-normal text-gray-500">({{ count($produk) }} hidangan)</span>
                            </h2>
 
                            <div class="relative">
                                <select
                                    class="appearance-none rounded-lg border border-white/10 bg-[#1e1e1e] py-2 pl-4 pr-9 text-sm font-medium text-gray-200 focus:border-[#ff6b00] focus:outline-none">
                                    <option>Terpopuler</option>
                                    <option>Termurah</option>
                                    <option>Termahal</option>
                                </select>
                                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
 
                        {{-- Grid produk (3 kolom di desktop) --}}
                        <div class="grid gap-5 sm:grid-cols-2 2xl:grid-cols-3">
                            @foreach ($produk as $item)
                                {{--
                                    Data dirender sekali oleh Blade (server-side), lalu Alpine yang
                                    sembunyikan/tampilkan card via x-show sesuai kategoriAktif — jadi
                                    filter kategori terasa instan tanpa reload/roundtrip ke server.
                                --}}
                                <div
                                    x-show="kategoriAktif === 'semua' || kategoriAktif === '{{ $item['kategori'] }}'"
                                    x-cloak
                                    class="group relative flex flex-col overflow-hidden rounded-2xl border border-white/5 bg-[#1e1e1e] transition hover:border-white/10">
 
                                    {{-- Gambar + badge --}}
                                    <div class="relative aspect-[4/3] overflow-hidden bg-black/30">
                                        {{-- Ganti src dengan foto asli, taruh di public/images/menu/ --}}
                                        <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}"
                                            class="h-full w-full object-cover {{ $item['stokHabis'] ? 'opacity-40 grayscale' : '' }}">
 
                                        @if (count($item['badges']))
                                            <div class="absolute left-3 top-3 flex flex-wrap gap-1.5">
                                                @foreach ($item['badges'] as $badge)
                                                    <span
                                                        class="rounded-full px-2.5 py-1 text-[11px] font-semibold backdrop-blur-sm {{ $badgeStyles[$badge]['class'] ?? 'bg-white/10 text-gray-300' }}">
                                                        {{ $badgeStyles[$badge]['emoji'] ?? '' }} {{ $badge }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
 
                                        @if ($item['stokHabis'])
                                            <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                                                <span class="rounded-md bg-black/70 px-3 py-1.5 text-sm font-semibold text-gray-200">
                                                    Stok Habis
                                                </span>
                                            </div>
                                        @else
                                            <button type="button" @click="tambahCepat({{ $item['id'] }})"
                                                class="absolute bottom-3 right-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-[#ff6b00] text-white shadow-lg transition hover:brightness-110 active:scale-95"
                                                aria-label="Tambah {{ $item['nama'] }} ke keranjang">
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
 
                                    {{-- Konten teks --}}
                                    <div class="flex flex-1 flex-col gap-1.5 p-4">
                                        {{-- "Stretched link": pseudo-element ::after memperluas area klik tombol judul ke
                                             seluruh card, tanpa membungkus tombol "+" di dalam elemen interaktif lain. --}}
                                        <h3 class="font-semibold text-white">
                                            <button type="button" @click="bukaModal({{ $item['id'] }})" @disabled($item['stokHabis'])
                                                class="text-left after:absolute after:inset-0 focus-visible:outline-none focus-visible:after:ring-2 focus-visible:after:ring-inset focus-visible:after:ring-[#ff6b00] disabled:cursor-not-allowed">
                                                {{ $item['nama'] }}
                                            </button>
                                        </h3>
                                        <p class="line-clamp-2 text-sm text-gray-400">
                                            {{-- line-clamp butuh Tailwind v3.3+ (sudah bawaan, tanpa plugin tambahan) --}}
                                            {{ $item['deskripsi'] }}
                                        </p>
                                        <div class="mt-2 flex items-center justify-between">
                                            <span class="text-lg font-bold text-[#ff6b00]">
                                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                            </span>
                                            <span class="flex items-center gap-1 text-xs text-gray-500">
                                                🔥 {{ $item['terjual'] }} terjual
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
 
                </div>
            </section>
        </main>
 
        {{-- ============ PANEL KERANJANG ============ --}}
        {{-- Backdrop: hanya muncul di layar < xl saat drawer terbuka --}}
        <div x-show="cartOpen" x-cloak x-transition.opacity @click="cartOpen = false"
            class="fixed inset-0 z-[55] bg-black/60 xl:hidden" aria-hidden="true"></div>
 
        {{--
            Satu elemen, dua perilaku:
            - < xl : `fixed` + digeser keluar layar (translate-x-full); dibuka dengan menambah !translate-x-0 lewat :class.
            - >= xl: `sticky` sebagai kolom kanan permanen (xl:translate-x-0 mengalahkan state drawer).
            Default class (tertutup) ditulis statis supaya drawer tidak "berkedip" sebelum Alpine siap.
            Tinggi navbar = h-16 (4rem), makanya top/height memakai 4rem.
        --}}
        <aside aria-label="Keranjang belanja" :class="{ '!translate-x-0': cartOpen }"
            class="fixed inset-y-0 right-0 z-[60] flex w-full max-w-sm translate-x-full flex-col border-l border-white/10 bg-[#121212] transition-transform duration-300 xl:sticky xl:top-16 xl:z-auto xl:h-[calc(100vh-4rem)] xl:w-[340px] xl:max-w-none xl:shrink-0 xl:translate-x-0 xl:self-start">
 
            <div class="flex items-start justify-between gap-3 border-b border-white/5 px-5 py-5">
                <div>
                    <h2 class="text-lg font-bold text-white">Keranjang</h2>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-semibold text-[#ff6b00]">🪑 Meja 7</span> · Warung Bebek Bumbu Ireng
                    </p>
                </div>
                <button type="button" @click="cartOpen = false" aria-label="Tutup keranjang"
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/5 text-gray-400 transition hover:bg-white/10 hover:text-white xl:hidden">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
 
            <div class="flex-1 overflow-y-auto px-5 py-4">
                {{-- State kosong --}}
                <div x-show="keranjang.length === 0" x-cloak class="flex h-full flex-col items-center justify-center text-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-[#ff6b00]/10 text-[#ff6b00]">
                        <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m-10 0a2 2 0 104 0m6 0a2 2 0 104 0" />
                        </svg>
                    </div>
                    <p class="mt-5 text-lg font-bold text-white">Keranjang masih kosong</p>
                    <p class="mt-1 text-sm text-gray-500">Pilih menu favoritmu</p>
                </div>
 
                {{-- Daftar item --}}
                <ul x-show="keranjang.length > 0" x-cloak class="space-y-3">
                    <template x-for="item in keranjang" :key="item.key">
                        <li class="flex gap-3 rounded-xl border border-white/5 bg-[#1e1e1e] p-3">
                            <img :src="item.gambar" :alt="item.nama" class="h-16 w-16 shrink-0 rounded-lg object-cover">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="truncate text-sm font-semibold text-white" x-text="item.nama"></p>
                                    <button type="button" @click="hapus(item.key)" :aria-label="'Hapus ' + item.nama"
                                        class="shrink-0 text-gray-500 transition hover:text-red-400">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                                <p x-show="item.porsi" class="text-xs text-gray-500" x-text="'Porsi ' + item.porsi"></p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-sm font-bold text-[#ff6b00]" x-text="rupiah(item.harga * item.qty)"></span>
                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="ubahQty(item.key, -1)" aria-label="Kurangi jumlah"
                                            class="flex h-7 w-7 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" /></svg>
                                        </button>
                                        <span class="w-5 text-center text-sm font-semibold text-white" x-text="item.qty"></span>
                                        <button type="button" @click="ubahQty(item.key, 1)" aria-label="Tambah jumlah"
                                            class="flex h-7 w-7 items-center justify-center rounded-full bg-[#ff6b00] text-white transition hover:brightness-110">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
 
            {{-- Footer: ringkasan biaya + tombol bayar (hanya jika ada isi) --}}
            <div x-show="keranjang.length > 0" x-cloak class="border-t border-white/5 px-5 py-5">
                <dl class="space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-500">Subtotal</dt>
                        <dd class="font-semibold text-gray-200" x-text="rupiah(totalHarga)"></dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-500">Biaya layanan</dt>
                        <dd class="font-semibold text-[#10b981]">Gratis</dd>
                    </div>
                </dl>
                <div class="mt-3 flex items-center justify-between border-t border-white/5 pt-3">
                    <span class="font-bold text-white">Total</span>
                    <span class="text-xl font-extrabold text-[#ff6b00]" x-text="rupiah(totalHarga)"></span>
                </div>
                <button type="button" @click="bukaCheckout()"
                    class="mt-4 flex w-full items-center justify-center gap-2 rounded-2xl bg-[#ff6b00] py-4 font-bold text-white shadow-lg shadow-[#ff6b00]/20 transition hover:brightness-110 active:scale-[0.98]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M6 15h4M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" /></svg>
                    Bayar Sekarang
                </button>
            </div>
        </aside>
    </div>
 
    {{-- ============ MODAL DETAIL PRODUK ============ --}}
    <div x-show="modalBuka" x-cloak
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        @click.self="tutupModal()"
        class="fixed inset-0 z-[70] flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm">
 
        <div x-show="modalBuka"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            role="dialog" aria-modal="true" aria-labelledby="modal-judul"
            class="max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-2xl bg-[#1e1e1e] shadow-2xl shadow-black/50">
 
            {{-- x-if: konten baru dibuat setelah ada produk terpilih (menghindari error `null.nama`).
                 produkDipilih sengaja tidak di-null-kan saat tutup, supaya isi modal tidak kosong selama animasi keluar. --}}
            <template x-if="produkDipilih">
                <div class="grid md:grid-cols-2">
 
                    {{-- Kiri: foto besar + badge --}}
                    <div class="relative h-56 md:h-auto md:min-h-[26rem]">
                        <img :src="produkDipilih.gambar" :alt="produkDipilih.nama" class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 flex flex-wrap gap-1.5">
                            <template x-for="b in produkDipilih.badges" :key="b">
                                <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold backdrop-blur-sm"
                                    :class="badgeStyles[b]?.class ?? 'bg-white/10 text-gray-300'"
                                    x-text="(badgeStyles[b]?.emoji ?? '') + ' ' + b"></span>
                            </template>
                        </div>
                    </div>
 
                    {{-- Kanan: info + opsi --}}
                    <div class="flex flex-col p-6 sm:p-8">
                        <div class="flex items-start justify-between gap-4">
                            <h2 id="modal-judul" class="text-2xl font-extrabold leading-tight text-white" x-text="produkDipilih.nama"></h2>
                            <button type="button" @click="tutupModal()" aria-label="Tutup"
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/5 text-gray-400 transition hover:bg-white/10 hover:text-white">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
 
                        <p class="mt-2 text-2xl font-bold text-[#ff6b00]" x-text="rupiah(hargaSatuanModal)"></p>
                        <p class="mt-4 text-sm leading-relaxed text-gray-300" x-text="produkDipilih.deskripsi"></p>
 
                        {{-- Pilih porsi (disembunyikan bila produk tidak punya opsi porsi) --}}
                        <div x-show="produkDipilih.porsi.length > 0" class="mt-6">
                            <p id="label-porsi" class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-500">Pilih Porsi</p>
                            <div role="radiogroup" aria-labelledby="label-porsi" class="grid grid-cols-3 gap-3">
                                <template x-for="(p, i) in produkDipilih.porsi" :key="p.nama">
                                    <button type="button" role="radio" :aria-checked="porsiIndex === i" @click="porsiIndex = i"
                                        :class="porsiIndex === i
                                            ? 'border-[#ff6b00] bg-[#ff6b00]/10 text-[#ff6b00]'
                                            : 'border-white/10 bg-white/5 text-gray-300 hover:border-white/20'"
                                        class="flex flex-col items-center justify-center rounded-xl border px-2 py-3.5 text-sm font-semibold transition">
                                        <span x-text="p.nama"></span>
                                        <span x-show="p.tambahan > 0" class="mt-0.5 text-xs font-normal text-[#ff6b00]" x-text="'+' + rupiah(p.tambahan)"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
 
                        {{-- Counter jumlah --}}
                        <div class="mt-6 flex items-center justify-between">
                            <span class="text-xs font-semibold uppercase tracking-widest text-gray-500">Jumlah</span>
                            <div class="flex items-center gap-4">
                                <button type="button" @click="jumlah = Math.max(1, jumlah - 1)" :disabled="jumlah <= 1" aria-label="Kurangi jumlah"
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20 disabled:cursor-not-allowed disabled:opacity-40">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" /></svg>
                                </button>
                                <span class="w-6 text-center text-xl font-bold text-white" x-text="jumlah" aria-live="polite"></span>
                                <button type="button" @click="jumlah = Math.min(99, jumlah + 1)" aria-label="Tambah jumlah"
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-[#ff6b00] text-white transition hover:brightness-110">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                </button>
                            </div>
                        </div>
 
                        {{-- CTA --}}
                        <button type="button" @click="tambahKeKeranjang()"
                            class="mt-8 flex w-full items-center justify-between rounded-2xl bg-[#ff6b00] px-6 py-4 font-bold text-white shadow-lg shadow-[#ff6b00]/20 transition hover:brightness-110 active:scale-[0.99] md:mt-auto">
                            <span>Tambah ke Keranjang</span>
                            <span x-text="rupiah(totalModal)"></span>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
 
    {{-- ============ MODAL CHECKOUT & PEMBAYARAN (3 langkah) ============ --}}
    {{-- Sengaja TIDAK menutup saat klik backdrop: ada input catatan & alur bayar yang mudah hilang kalau kepencet. --}}
    <div x-show="openCheckout" x-cloak
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[80] flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm">
 
        <div x-show="openCheckout"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            role="dialog" aria-modal="true" aria-labelledby="checkout-judul"
            class="flex max-h-[92vh] w-full max-w-md flex-col overflow-hidden rounded-2xl border border-[#2a2a2a] bg-[#121212] shadow-2xl shadow-black/60">
 
            {{-- Header: stepper + judul + tombol close --}}
            <div class="shrink-0 border-b border-[#2a2a2a] px-5 pb-4 pt-5 sm:px-6">
                <ol class="flex items-center gap-1.5 sm:gap-2" aria-label="Langkah checkout">
                    <template x-for="(s, i) in langkah" :key="s.n">
                        <li class="flex items-center gap-1.5 sm:gap-2" :class="{ 'flex-1': i < langkah.length - 1 }">
                            {{-- Langkah yang sudah dilewati bisa diklik untuk kembali --}}
                            <button type="button" @click="step = s.n" :disabled="s.n >= step" :aria-current="step === s.n ? 'step' : null"
                                class="flex items-center gap-1.5 disabled:cursor-default sm:gap-2">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-sm font-bold transition"
                                    :class="s.n < step
                                        ? 'bg-[#ff6b00] text-white'
                                        : s.n === step
                                            ? 'bg-[#ff6b00] text-white ring-2 ring-[#ff6b00]/40 ring-offset-2 ring-offset-[#121212]'
                                            : 'bg-[#2a2a2a] text-gray-500'">
                                    <svg x-show="s.n < step" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    <span x-show="s.n >= step" x-text="s.n"></span>
                                </span>
                                <span class="text-xs font-semibold sm:text-sm" :class="s.n <= step ? 'text-gray-100' : 'text-gray-500'" x-text="s.label"></span>
                            </button>
                            <span x-show="i < langkah.length - 1" class="h-px flex-1 transition-colors"
                                :class="s.n < step ? 'bg-[#ff6b00]' : 'bg-[#2a2a2a]'"></span>
                        </li>
                    </template>
                </ol>
 
                <div class="mt-5 flex items-center justify-between gap-4">
                    <h2 id="checkout-judul" class="text-xl font-extrabold text-white" x-text="langkah[step - 1].judul"></h2>
                    <button type="button" @click="tutupCheckout()" aria-label="Tutup checkout"
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#1e1e1e] text-gray-400 transition hover:bg-[#2a2a2a] hover:text-white">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
 
            {{-- Isi (scroll di sini, header & tombol tetap terlihat) --}}
            <div x-ref="checkoutBody" class="flex-1 overflow-y-auto px-5 py-5 sm:px-6">
 
                {{-- ===== STEP 1: Ringkasan Pesanan ===== --}}
                <div x-show="step === 1" class="space-y-5">
                    <div class="flex items-center justify-between gap-3 rounded-xl border border-[#ff6b00]/30 bg-[#ff6b00]/10 px-4 py-3">
                        <span class="font-bold text-[#ff6b00]">🪑 Meja 7</span>
                        <span class="text-sm text-gray-400">Warung Bebek Protol</span>
                    </div>
 
                    <ul class="space-y-2.5">
                        <template x-for="item in keranjang" :key="item.key">
                            <li class="flex items-center gap-3 rounded-xl border border-[#2a2a2a] bg-[#1e1e1e] p-3">
                                <img :src="item.gambar" :alt="item.nama" class="h-12 w-12 shrink-0 rounded-lg object-cover">
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-semibold text-white" x-text="item.nama"></p>
                                    <p class="text-xs text-gray-500" x-text="item.qty + 'x' + (item.porsi ? ' · Porsi ' + item.porsi : '')"></p>
                                </div>
                                <span class="shrink-0 text-sm font-bold text-[#ff6b00]" x-text="rupiah(item.harga * item.qty)"></span>
                            </li>
                        </template>
                    </ul>
 
                    <div>
                        <label for="catatan-dapur" class="mb-2 block text-xs font-medium text-gray-500">Catatan untuk dapur (opsional)</label>
                        <textarea id="catatan-dapur" x-model="notes" rows="3" maxlength="200"
                            placeholder="Contoh: bebek minta lebih matang, tidak pakai sambal..."
                            class="w-full resize-none rounded-xl border border-[#2a2a2a] bg-[#1e1e1e] px-4 py-3 text-sm text-gray-200 placeholder:text-gray-600 focus:border-[#ff6b00] focus:outline-none"></textarea>
                    </div>
 
                    <div class="rounded-xl border border-[#2a2a2a] bg-[#1e1e1e] p-4">
                        <ul class="space-y-2 text-sm">
                            <template x-for="item in keranjang" :key="'ringkas-' + item.key">
                                <li class="flex justify-between gap-3 text-gray-400">
                                    <span class="truncate" x-text="item.qty + 'x ' + item.nama"></span>
                                    <span class="shrink-0 text-gray-200" x-text="rupiah(item.harga * item.qty)"></span>
                                </li>
                            </template>
                        </ul>
                        <div class="mt-3 flex items-center justify-between border-t border-[#2a2a2a] pt-3">
                            <span class="font-bold text-white">Total Tagihan</span>
                            <span class="text-xl font-extrabold text-[#ff6b00]" x-text="rupiah(totalHarga)"></span>
                        </div>
                    </div>
                </div>
 
                {{-- ===== STEP 2: Pilih Metode Pembayaran ===== --}}
                <div x-show="step === 2" x-cloak>
                    <div role="radiogroup" aria-label="Metode pembayaran" class="space-y-2.5">
                        <template x-for="m in metodeBayar" :key="m.id">
                            <button type="button" role="radio" :aria-checked="selectedPayment === m.id" @click="selectedPayment = m.id"
                                :class="selectedPayment === m.id
                                    ? 'border-[#ff6b00] bg-[#ff6b00]/10'
                                    : 'border-[#2a2a2a] bg-[#1e1e1e] hover:border-gray-600'"
                                class="flex w-full items-center gap-3 rounded-xl border px-4 py-3.5 text-left transition">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center text-2xl" x-text="m.icon"></span>
                                <span class="min-w-0 flex-1">
                                    <span class="block font-semibold text-white" x-text="m.nama"></span>
                                    <span class="block text-sm text-gray-500" x-text="m.deskripsi"></span>
                                </span>
                                <span x-show="m.tipe === 'qr'" class="rounded-md bg-[#2a2a2a] px-2 py-1 text-[11px] font-bold text-gray-400">QR</span>
                                {{-- Indikator radio: pilihan tidak hanya dibedakan lewat warna --}}
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2 transition"
                                    :class="selectedPayment === m.id ? 'border-[#ff6b00]' : 'border-gray-600'">
                                    <span x-show="selectedPayment === m.id" class="h-2.5 w-2.5 rounded-full bg-[#ff6b00]"></span>
                                </span>
                            </button>
                        </template>
                    </div>
                </div>
 
                {{-- ===== STEP 3: Selesaikan Pembayaran ===== --}}
                <div x-show="step === 3" x-cloak class="flex flex-col items-center text-center">
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#2a2a2a] bg-[#1e1e1e] px-4 py-2 text-sm font-semibold text-white">
                        <span x-text="metodeAktif?.icon"></span>
                        <span x-text="metodeAktif?.nama"></span>
                    </div>
 
                    {{-- Tipe QR (DANA, GoPay, OVO) --}}
                    <div x-show="metodeAktif?.tipe === 'qr'" class="mt-4 flex flex-col items-center">
                        <p class="text-sm text-gray-500">Scan QR di bawah untuk membayar</p>
                        {{-- Placeholder QR (pola dibuat di JS, TIDAK bisa di-scan). Di produksi: ganti dengan
                             <img :src="..."> dari payment gateway (Midtrans/Xendit mengembalikan URL / qr_string). --}}
                        <div class="mt-4 rounded-2xl bg-white p-4">
                            <svg viewBox="-1 -1 23 23" shape-rendering="crispEdges" class="h-52 w-52 sm:h-56 sm:w-56" role="img" aria-label="QR code pembayaran (placeholder)">
                                <path :d="qrPath" fill="#000" />
                            </svg>
                        </div>
                    </div>
 
                    {{-- Tipe Virtual Account (BCA, Mandiri, BNI) --}}
                    <div x-show="metodeAktif?.tipe === 'va'" class="mt-4 w-full">
                        <p class="text-sm text-gray-500">Transfer ke nomor Virtual Account</p>
                        <div class="mt-4 rounded-2xl border border-[#2a2a2a] bg-[#1e1e1e] px-4 py-6 font-mono text-xl font-bold tracking-wider text-white sm:text-2xl" x-text="nomorVA"></div>
                        <p class="mt-2 text-xs text-gray-600">Nomor contoh — di produksi dibuat oleh payment gateway.</p>
                    </div>
 
                    {{-- Tipe Kasir --}}
                    <div x-show="metodeAktif?.tipe === 'kasir'" class="mt-4 w-full">
                        <p class="text-sm text-gray-500">Tunjukkan kode ini ke kasir</p>
                        <div class="mt-4 rounded-2xl border border-[#2a2a2a] bg-[#1e1e1e] px-4 py-6 font-mono text-2xl font-bold tracking-widest text-white" x-text="kodePesanan"></div>
                    </div>
 
                    <p class="mt-5 text-3xl font-extrabold text-white" x-text="rupiah(totalHarga)"></p>
                    <p class="mt-1 text-xs" :class="kedaluwarsa ? 'text-red-400' : 'text-gray-500'">
                        <span x-show="!kedaluwarsa">Bayar dalam <span class="font-bold text-[#ff6b00]" x-text="timerTeks"></span></span>
                        <span x-show="kedaluwarsa">Waktu pembayaran habis.
                            <button type="button" @click="mulaiTimer()" class="font-semibold text-[#ff6b00] underline">Buat ulang kode</button>
                        </span>
                    </p>
                </div>
            </div>
 
            {{-- Footer: tombol aksi per langkah --}}
            <div class="shrink-0 border-t border-[#2a2a2a] px-5 py-4 sm:px-6">
                <button x-show="step === 1" type="button" @click="step = 2"
                    class="w-full rounded-2xl bg-[#ff6b00] py-4 font-bold text-white shadow-lg shadow-[#ff6b00]/20 transition hover:brightness-110 active:scale-[0.99]">
                    Pilih Metode Pembayaran →
                </button>
 
                <button x-show="step === 2" x-cloak type="button" @click="step = 3" :disabled="!selectedPayment"
                    class="w-full rounded-2xl bg-[#ff6b00] py-4 font-bold text-white shadow-lg shadow-[#ff6b00]/20 transition hover:brightness-110 active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-40 disabled:shadow-none disabled:hover:brightness-100">
                    <span x-text="'Bayar ' + rupiah(totalHarga) + ' →'"></span>
                </button>
 
                <div x-show="step === 3" x-cloak class="text-center">
                    {{-- Klik ini hanya "klaim" dari pengguna; status lunas asli harus datang dari backend/webhook. --}}
                    <button type="button" @click="selesaiBayar()" :disabled="kedaluwarsa"
                        class="w-full rounded-2xl bg-[#10b981] py-4 font-bold text-white shadow-lg shadow-[#10b981]/20 transition hover:brightness-110 active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-40 disabled:shadow-none disabled:hover:brightness-100">
                        ✓ Saya Sudah Bayar
                    </button>
                    <button type="button" @click="step = 2" class="mt-3 text-sm text-gray-500 transition hover:text-gray-300">
                        ← Ganti metode pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>
 
    {{-- Toast konfirmasi --}}
    <div x-show="notif" x-cloak x-transition.opacity role="status"
        class="fixed bottom-6 left-1/2 z-[90] w-max max-w-[90vw] -translate-x-1/2 rounded-full bg-[#10b981] px-5 py-3 text-center text-sm font-semibold text-white shadow-lg"
        x-text="notif"></div>
 
    {{-- ============ LOGIKA ALPINE ============ --}}
    {{-- Didaftarkan lewat event `alpine:init` supaya jalan baik dengan Alpine dari Vite maupun CDN. --}}
        <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>
