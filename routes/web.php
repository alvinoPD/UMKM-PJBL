<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // 1. Data Porsi Dummy
    $porsiMakanan = [
        ['nama' => 'Standar', 'tambahan' => 0],
        ['nama' => 'Reguler', 'tambahan' => 0],
        ['nama' => 'Jumbo', 'tambahan' => 8000],
    ];

    // 2. Data Produk Dummy
    $produk = [
        [
            'id' => 1,
            'nama' => 'Bebek Goreng Bumbu Ireng',
            'kategori' => 'makanan',
            'harga' => 22000,
            'terjual' => 420,
            'deskripsi' => 'Kenikmatan bebek goreng Madura legendaris dengan daging empuk, bumbu hitam gurih pekat kaya rempah tradisional.',
            'gambar' => asset('images/menu/bebek-goreng.jpg'),
            'porsi' => $porsiMakanan,
            'badges' => ['Best Seller', 'Pedas'],
            'stokHabis' => false,
        ],
        [
            'id' => 2,
            'nama' => 'Ayam Goreng Sambal Korek',
            'kategori' => 'makanan',
            'harga' => 20000,
            'terjual' => 98,
            'deskripsi' => 'Ayam goreng renyah keemasan disajikan dengan sambal korek segar dan lalapan.',
            'gambar' => asset('images/menu/ayam-goreng.jpg'),
            'porsi' => $porsiMakanan,
            'badges' => ['Pedas'],
            'stokHabis' => false,
        ],
        [
            'id' => 3,
            'nama' => 'Es Teh Manis Jumbo',
            'kategori' => 'minuman',
            'harga' => 5000,
            'terjual' => 145,
            'deskripsi' => 'Es teh manis segar ukuran jumbo pelepas dahaga, cocok menemani menu pedas.',
            'gambar' => asset('images/menu/es-teh.jpg'),
            'porsi' => [],
            'badges' => [],
            'stokHabis' => false,
        ],
        [
            'id' => 4,
            'nama' => 'Es Jeruk Peras Murni',
            'kategori' => 'minuman',
            'harga' => 7000,
            'terjual' => 98,
            'deskripsi' => 'Jeruk peras segar 100% tanpa campuran, didinginkan dengan es batu alami.',
            'gambar' => asset('images/menu/es-jeruk.jpg'),
            'porsi' => [],
            'badges' => [],
            'stokHabis' => true,
        ],
    ];

    // 3. Data Style Badge
    $badgeStyles = [
        'Best Seller' => ['emoji' => '⭐', 'class' => 'bg-yellow-500/15 text-yellow-400'],
        'Pedas' => ['emoji' => '🔥', 'class' => 'bg-red-500/15 text-red-400'],
        'Rekomendasi' => ['emoji' => '👍', 'class' => 'bg-blue-500/15 text-blue-400'],
    ];

    // 4. Kirim data ke index.blade.php
    return view('index', compact('produk', 'badgeStyles', 'porsiMakanan'));
});

// Route BebekController biarkan saja seperti aslinya
Route::get('/produk', [\App\Http\Controllers\BebekController::class, 'index']);

Route::get('/kasir', function () {
    return view('kasir');
});