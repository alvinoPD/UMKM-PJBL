<!DOCTYPE html>
<html lang="id" class="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Bumbu Ireng — Kasir & Monitor Pesanan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
[x-cloak] { display: none !important; }
.scroll-dark::-webkit-scrollbar { width: 8px; height: 8px; }
.scroll-dark::-webkit-scrollbar-track { background: transparent; }
.scroll-dark::-webkit-scrollbar-thumb { background: #2a2a2a; border-radius: 9999px; }
.scroll-dark::-webkit-scrollbar-thumb:hover { background: #3a3a3a; }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body x-data="{ activeTab: 'pos' }" class="h-screen overflow-hidden bg-[#111111] font-sans text-neutral-100 antialiased">
<div class="flex h-screen">
    <!-- SIDEBAR -->
    <aside class="flex w-64 shrink-0 flex-col border-r border-white/[0.06] bg-[#0d0d0d]">
        <!-- Logo -->
        <div class="px-5 pb-5 pt-6">
            <div class="flex items-center gap-2.5">
                <span class="text-2xl leading-none">🦆</span>
                <span class="text-xl font-extrabold tracking-tight text-[#ff6b00]">Bebek Protol</span>
            </div>
            <p class="mt-1 text-xs text-neutral-500">Kasir POS Terminal</p>
        </div>
        
        <!-- Navigasi -->
        <nav class="flex-1 space-y-1.5 border-t border-white/[0.06] px-3 py-4">
            <!-- POS Terminal -->
            <button type="button" x-on:click="activeTab = 'pos'"
                :class="activeTab === 'pos' ? 'border-[#ff6b00]/40 bg-[#ff6b00]/10 text-[#ff8a3d]' : 'border-transparent text-neutral-400 hover:bg-white/5 hover:text-neutral-200'"
                class="flex w-full items-center gap-3 rounded-xl border px-3.5 py-3 text-left text-sm font-semibold transition-colors">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16v10H4zM8 19h8M12 15v4"/></svg>
                <span class="flex-1">POS Terminal</span>
            </button>

            <!-- Monitor Pesanan -->
            <button type="button" x-on:click="activeTab = 'monitor'"
                :class="activeTab === 'monitor' ? 'border-[#ff6b00]/40 bg-[#ff6b00]/10 text-[#ff8a3d]' : 'border-transparent text-neutral-400 hover:bg-white/5 hover:text-neutral-200'"
                class="flex w-full items-center gap-3 rounded-xl border px-3.5 py-3 text-left text-sm font-semibold transition-colors">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4h6v3H9zM7 5H6a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1h-1M9 12h6M9 16h4"/></svg>
                <span class="flex-1 leading-tight">Monitor<br>Pesanan</span>
                <!-- <span class="flex h-5 min-w-[20px] items-center justify-center rounded-full bg-[#ff6b00]/20 px-1.5 text-[11px] font-bold text-[#ff8a3d]"></span> -->
            </button>

            <!-- Peta Meja -->
            <!-- <button type="button" x-on:click="activeTab = 'meja'"
                :class="activeTab === 'meja' ? 'border-[#ff6b00]/40 bg-[#ff6b00]/10 text-[#ff8a3d]' : 'border-transparent text-neutral-400 hover:bg-white/5 hover:text-neutral-200'"
                class="flex w-full items-center gap-3 rounded-xl border px-3.5 py-3 text-left text-sm font-semibold transition-colors">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4 3 6v14l6-2 6 2 6-2V4l-6 2-6-2zM9 4v14M15 6v14"/></svg>
                <span class="flex-1">Peta Meja</span>
                <span class="flex h-5 min-w-[20px] items-center justify-center rounded-full bg-emerald-500/20 px-1.5 text-[11px] font-bold text-emerald-400">1</span>
            </button> -->

            <!-- Rekap Harian -->
            <button type="button" x-on:click="activeTab = 'rekap'"
                :class="activeTab === 'rekap' ? 'border-[#ff6b00]/40 bg-[#ff6b00]/10 text-[#ff8a3d]' : 'border-transparent text-neutral-400 hover:bg-white/5 hover:text-neutral-200'"
                class="flex w-full items-center gap-3 rounded-xl border px-3.5 py-3 text-left text-sm font-semibold transition-colors">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20V4M4 20h16M8 15l3-4 3 2 5-6"/></svg>
                <span class="flex-1">Rekap Harian</span>
            </button>
        </nav>

        <!-- Profil & Shift -->
        <div class="border-t border-white/[0.06] p-4" x-data="{ shiftOn: true }">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-500/15 text-sm font-bold text-blue-400 ring-1 ring-blue-500/30">SR</div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold">Siti Rahayu</p>
                    <p class="text-xs text-neutral-500">Kasir · Shift Siang</p>
                </div>
            </div>
            <button type="button" x-on:click="shiftOn = !shiftOn"
                :class="shiftOn ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/15' : 'border-white/10 bg-white/5 text-neutral-300 hover:bg-white/10'"
                class="mt-3 w-full rounded-lg border px-3 py-2.5 text-center text-xs font-semibold transition-colors">
                <span x-show="shiftOn">Shift aktif sejak 10:00</span>
                <span x-show="!shiftOn" x-cloak>Shift selesai · Mulai shift</span>
            </button>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="h-screen min-w-0 flex-1 overflow-hidden">
        <!-- PANEL POS -->
        <section x-show="activeTab === 'pos'" x-data="posApp()" class="flex h-full">
            <!-- Tengah: menu -->
            <div class="flex min-w-0 flex-1 flex-col">
                <!-- Filter kategori -->
                <header class="flex items-center gap-2 border-b border-white/[0.06] px-6 py-4">
                    <template x-for="c in categories" :key="c.key">
                        <button type="button" x-on:click="category = c.key"
                            :class="category === c.key ? 'bg-[#ff6b00] text-white' : 'bg-white/[0.06] text-neutral-300 hover:bg-white/10'"
                            class="rounded-full px-4 py-2 text-sm font-semibold transition-colors"
                            x-text="c.label"></button>
                    </template>
                    <span class="ml-auto text-sm text-neutral-500" x-text="availableCount + ' tersedia'"></span>
                </header>

                <!-- Grid kartu menu -->
                <div class="scroll-dark flex-1 overflow-y-auto p-6">
                    <div class="grid grid-cols-[repeat(auto-fill,minmax(176px,1fr))] gap-4">
                        <template x-for="m in filtered" :key="m.id">
                            <button type="button" x-on:click="add(m)" :disabled="!m.available"
                                :class="m.available ? 'hover:border-[#ff6b00]/50 hover:bg-[#1a1a1a] active:scale-[0.98]' : 'cursor-not-allowed opacity-50'"
                                class="group relative flex flex-col overflow-hidden rounded-2xl border border-white/[0.07] bg-[#161616] text-left transition">
                                <!-- Foto -->
                                <div class="relative h-28 w-full overflow-hidden bg-gradient-to-br from-[#2a1a0e] to-[#151515]">
                                    <span class="absolute inset-0 flex items-center justify-center text-4xl" x-text="m.emoji"></span>
                                    <img :src="m.img" :alt="m.name" loading="lazy"
                                        x-on:error="$el.style.display = 'none'"
                                        :class="m.available ? '' : 'grayscale'"
                                        class="absolute inset-0 h-full w-full object-cover">
                                    <!-- Label -->
                                    <span x-show="m.label" x-text="m.label"
                                        class="absolute left-2 top-2 rounded-md border border-[#ff6b00]/40 bg-black/60 px-2 py-0.5 text-[10px] font-semibold text-[#ff8a3d] backdrop-blur"></span>
                                    <!-- Jumlah di keranjang -->
                                    <span x-show="qtyOf(m.id) > 0" x-text="qtyOf(m.id)"
                                        class="absolute right-2 top-2 flex h-6 min-w-[24px] items-center justify-center rounded-full bg-[#ff6b00] px-1.5 text-xs font-bold text-white shadow-lg"></span>
                                    <!-- Habis -->
                                    <span x-show="!m.available"
                                        class="absolute inset-0 flex items-center justify-center bg-black/50 text-sm font-bold text-neutral-200">Habis</span>
                                </div>
                                <!-- Info -->
                                <div class="flex flex-1 flex-col justify-between gap-2 p-3">
                                    <p class="text-[13px] font-semibold leading-snug text-neutral-100" x-text="m.name"></p>
                                    <p class="text-[15px] font-bold text-[#ff6b00]" x-text="rp(m.price)"></p>
                                </div>
                            </button>
                        </template>
                    </div>
                    <p x-show="filtered.length === 0" x-cloak class="py-16 text-center text-sm text-neutral-500">Belum ada menu di kategori ini.</p>
                </div>
            </div>

            <!-- Kanan: keranjang -->
            <aside class="flex w-[384px] shrink-0 flex-col border-l border-white/[0.06] bg-[#0f0f0f]">
                <!-- Jenis pesanan -->
                <div class="grid grid-cols-2 gap-2 p-4">
                    <button type="button" x-on:click="orderType = 'meja'"
                        :class="orderType === 'meja' ? 'bg-[#ff6b00] text-white' : 'bg-white/[0.06] text-neutral-300 hover:bg-white/10'"
                        class="flex items-center justify-center gap-2 rounded-xl py-2.5 text-sm font-semibold transition-colors">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 10h16M6 10v9M18 10v9M3 6h18v4H3z"/></svg>
                        Meja
                    </button>
                    <button type="button" x-on:click="orderType = 'takeaway'"
                        :class="orderType === 'takeaway' ? 'bg-[#ff6b00] text-white' : 'bg-white/[0.06] text-neutral-300 hover:bg-white/10'"
                        class="flex items-center justify-center gap-2 rounded-xl py-2.5 text-sm font-semibold transition-colors">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8h12l-1 12H7zM9 8a3 3 0 0 1 6 0"/></svg>
                        Takeaway
                    </button>
                </div>

                <!-- Nomor meja / nama pemesan -->
                <div class="border-b border-white/[0.06] px-4 pb-4">
                    <div x-show="orderType === 'meja'" class="flex items-center justify-between">
                        <label class="text-sm text-neutral-400">Nomor Meja:</label>
                        <div class="flex items-center gap-3">
                            <button type="button" x-on:click="tableDec()" aria-label="Kurangi nomor meja"
                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/[0.08] text-lg font-bold leading-none text-neutral-200 hover:bg-white/15">−</button>
                            <input type="number" min="1" x-model.number="tableNo" aria-label="Nomor meja"
                                class="w-10 bg-transparent text-center text-base font-bold text-neutral-100 outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none">
                            <button type="button" x-on:click="tableInc()" aria-label="Tambah nomor meja"
                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#ff6b00] text-lg font-bold leading-none text-white hover:bg-[#ff7d1f]">+</button>
                        </div>
                    </div>
                    <div x-show="orderType === 'takeaway'" x-cloak class="flex items-center gap-3">
                        <label class="shrink-0 text-sm text-neutral-400">Nama:</label>
                        <input type="text" x-model="customerName" placeholder="Nama pemesan"
                            class="w-full rounded-lg border border-white/10 bg-white/[0.04] px-3 py-2 text-sm text-neutral-100 placeholder-neutral-600 outline-none focus:border-[#ff6b00]/60">
                    </div>
                </div>

                <!-- Daftar pesanan -->
                <div class="scroll-dark flex-1 overflow-y-auto">
                    <!-- Empty state -->
                    <div x-show="cart.length === 0" class="flex h-full flex-col items-center justify-center gap-3 px-8 text-center">
                        <svg class="h-14 w-14 text-neutral-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M3 4h2l2.4 10.2a1 1 0 0 0 1 .8h8.7a1 1 0 0 0 1-.8L20 8H6M9 20h.01M17 20h.01"/></svg>
                        <p class="text-sm text-neutral-500">Klik menu di kiri untuk menambah pesanan</p>
                    </div>
                    <!-- Item -->
                    <ul x-show="cart.length > 0" x-cloak class="divide-y divide-white/[0.05]">
                        <template x-for="item in cart" :key="item.id">
                            <li class="flex items-center gap-3 px-4 py-3">
                                <div class="relative h-12 w-12 shrink-0 overflow-hidden rounded-lg bg-gradient-to-br from-[#2a1a0e] to-[#151515]">
                                    <span class="absolute inset-0 flex items-center justify-center text-xl" x-text="item.emoji"></span>
                                    <img :src="item.img" :alt="item.name" x-on:error="$el.style.display = 'none'" class="absolute inset-0 h-full w-full object-cover">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-[13px] font-semibold text-neutral-100" x-text="item.name"></p>
                                    <p class="text-xs text-neutral-500" x-text="rp(item.price)"></p>
                                </div>
                                <div class="flex flex-col items-end gap-1.5">
                                    <p class="text-[13px] font-bold text-[#ff6b00]" x-text="rp(item.price * item.qty)"></p>
                                    <div class="flex items-center gap-2">
                                        <button type="button" x-on:click="dec(item)" aria-label="Kurangi jumlah"
                                            class="flex h-6 w-6 items-center justify-center rounded-md bg-white/[0.08] text-sm font-bold leading-none text-neutral-200 hover:bg-white/15">−</button>
                                        <span class="w-5 text-center text-sm font-bold" x-text="item.qty"></span>
                                        <button type="button" x-on:click="inc(item)" aria-label="Tambah jumlah"
                                            class="flex h-6 w-6 items-center justify-center rounded-md bg-[#ff6b00] text-sm font-bold leading-none text-white hover:bg-[#ff7d1f]">+</button>
                                    </div>
                                </div>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Ringkasan & pembayaran -->
                <div class="border-t border-white/[0.06] p-4">
                    <div class="flex items-baseline justify-between">
                        <span class="text-sm text-neutral-400" x-text="itemCount + ' item'"></span>
                        <span class="text-2xl font-extrabold tracking-tight" x-text="rp(total)"></span>
                    </div>
                    <p class="mb-2 mt-4 text-xs text-neutral-500">Metode Pembayaran</p>
                    <div class="grid grid-cols-4 gap-2">
                        <template x-for="p in payments" :key="p">
                            <button type="button" x-on:click="payment = p"
                                :class="payment === p ? 'bg-[#ff6b00] text-white' : 'bg-white/[0.06] text-neutral-300 hover:bg-white/10'"
                                class="rounded-lg py-2 text-xs font-semibold transition-colors"
                                x-text="p"></button>
                        </template>
                    </div>
                    <button type="button" x-on:click="checkout()" :disabled="cart.length === 0"
                        class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-[#16a34a] py-3.5 text-sm font-bold text-white transition hover:bg-[#15b04f] active:scale-[0.99] disabled:cursor-not-allowed disabled:bg-[#0f4d27] disabled:text-white/40 disabled:hover:bg-[#0f4d27] disabled:active:scale-100">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 8V4h10v4M7 17H5a1 1 0 0 1-1-1v-6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6a1 1 0 0 1-1 1h-2M7 14h10v6H7z"/></svg>
                        Proses &amp; Cetak Struk
                    </button>
                </div>
            </aside>

            <!-- Toast -->
            <div x-show="toast" x-cloak x-transition.opacity
                class="fixed bottom-6 left-1/2 z-50 -translate-x-1/2 rounded-xl border border-emerald-500/30 bg-[#0f2a1a] px-5 py-3 text-sm font-semibold text-emerald-300 shadow-2xl"
                x-text="toast"></div>
        </section>

        <!-- PANEL MONITOR PESANAN -->
        <section x-show="activeTab === 'monitor'" x-data="monitorApp()" x-cloak class="flex h-full flex-col overflow-hidden bg-[#0a0a0a]">
            <!-- Header Section -->
            <header class="flex flex-col gap-4 border-b border-white/[0.06] px-8 py-6 md:flex-row md:items-center md:justify-between shrink-0">
                <div>
                    <h2 class="mb-1 text-2xl font-bold text-white">Monitor Pesanan</h2>
                    <p class="text-sm text-gray-400">
                        <span x-text="getCount('Semua') - getCount('Selesai')"></span> pesanan aktif.
                        <span x-text="getCount('Semua')"></span> total hari ini
                    </p>
                </div>
                <!-- Filter Pills -->
                <div class="flex flex-wrap gap-2">
                    <template x-for="filter in filters" :key="filter">
                        <button
                            type="button"
                            @click="activeFilter = filter"
                            :class="{
                                'bg-[#222222] text-white border-gray-600': activeFilter === filter,
                                'bg-transparent text-gray-400 border-[#222222] hover:border-gray-600': activeFilter !== filter
                            }"
                            class="flex items-center gap-2 rounded-full border px-4 py-1.5 text-sm font-medium transition-colors">
                            <span x-text="filter"></span>
                            <span 
                                class="rounded-full px-1.5 text-xs"
                                :class="{
                                    'bg-gray-600 text-white': activeFilter === filter,
                                    'bg-[#1a1a1a] text-gray-500': activeFilter !== filter
                                }"
                                x-text="getCount(filter)">
                            </span>
                        </button>
                    </template>
                </div>
            </header>

            <!-- Order Cards Container -->
            <div class="scroll-dark flex-1 overflow-y-auto px-8 py-6 space-y-4">
                <template x-for="order in filteredOrders" :key="order.id">
                    <!-- Individual Order Card -->
                    <div class="flex flex-col gap-4 rounded-xl border-t-2 p-5 transition-all duration-300 hover:shadow-lg md:flex-row md:justify-between"
                        :class="getCardTheme(order.status)">
                        <!-- Left Side: Details -->
                        <div class="flex-1">
                            <div class="mb-3 flex items-center gap-3">
                                <span class="text-lg font-bold tracking-wide text-white" x-text="order.id"></span>
                                <!-- Table Badge -->
                                <span class="flex items-center gap-1 rounded border border-orange-900/50 bg-[#361d0d] px-2 py-0.5 text-xs font-semibold text-orange-500">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"></path></svg>
                                    <span x-text="order.table"></span>
                                </span>
                                <!-- Status Badge -->
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wide"
                                    :class="getStatusBadgeStyle(order.status)"
                                    x-text="order.status">
                                </span>
                            </div>
                            <!-- Items List -->
                            <div class="text-sm leading-relaxed text-gray-300">
                                <span x-text="order.items.join(', ')"></span>
                            </div>
                            <!-- Special Note -->
                            <template x-if="order.note">
                                <div class="mt-2 flex items-start gap-1.5 text-sm text-amber-500">
                                    <svg class="mt-0.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    <span class="font-medium" x-text="order.note"></span>
                                </div>
                            </template>
                        </div>
                        <!-- Right Side: Action & Price -->
                        <div class="flex min-w-[120px] flex-row items-end justify-between text-right md:flex-col">
                            <div class="mb-3">
                                <div class="text-xl font-bold text-orange-500" x-text="order.price"></div>
                                <div class="mt-0.5 text-xs text-gray-500" x-text="order.payment"></div>
                            </div>
                            <!-- Dynamic Action Button -->
                            <button 
                                type="button"
                                x-show="order.status !== 'Selesai'"
                                @click="nextStatus(order)"
                                class="rounded-md px-4 py-1.5 text-sm font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 focus:ring-offset-[#111]"
                                :class="getButtonConfig(order.status).class"
                                x-text="getButtonConfig(order.status).text">
                            </button>
                            <!-- Static state for finished orders -->
                            <span x-show="order.status === 'Selesai'" class="rounded-md border border-gray-700 px-3 py-1 text-xs text-gray-600">
                                Terselesaikan
                            </span>
                        </div>
                    </div>
                </template>

                <!-- Empty State -->
                <div x-show="filteredOrders.length === 0" x-cloak class="py-12 text-center text-gray-500">
                    <svg class="mx-auto mb-3 h-12 w-12 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    <p>Tidak ada pesanan untuk filter ini.</p>
                </div>
            </div>
        </section>

        <!-- PANEL PETA MEJA -->
        <!--
        <section x-show="activeTab === 'meja'" x-cloak class="h-full overflow-y-auto p-6">
        ...
        </section>
        -->

        <!-- PANEL REKAP -->
        <!--
        <section x-show="activeTab === 'rekap'" x-cloak class="h-full overflow-y-auto p-6">
        ...
        </section>
        -->
    </main>
</div>
<script src="{{ asset('js/kasir.js') }}"></script>
</body>
</html>