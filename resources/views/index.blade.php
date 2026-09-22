<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bebek Protol - Super Pedas</title>
    <!-- Memanggil Tailwind CSS untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        spicy: '#dc2626', // Merah cabai
                        spicyLight: '#fef2f2', // Latar belakang merah muda
                        warm: '#f97316', // Oranye hangat
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    <!-- Navbar -->
    <nav class="bg-spicy text-white shadow-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="text-2xl font-bold tracking-wider">
                <i class="fa-solid fa-fire mr-2 text-yellow-300"></i>Bebek Protol
            </div>
            <div class="hidden md:flex space-x-6">
                <a href="#" class="hover:text-yellow-300 transition">Beranda</a>
                <a href="#menu" class="hover:text-yellow-300 transition">Menu Andalan</a>
                <a href="#lokasi" class="hover:text-yellow-300 transition">Lokasi</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-spicyLight py-20 px-4">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 md:pr-10 text-center md:text-left mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                    Rasakan Sensasi Pedas <span class="text-spicy">Bebek Protol</span> yang Menggugah Selera!
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Daging bebek super empuk yang dagingnya langsung "protol" dari tulang, dipadukan dengan racikan sambal rahasia yang bikin nagih.
                </p>
                <a href="#menu" class="bg-warm hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:-translate-y-1">
                    Lihat Menu Kami
                </a>
            </div>
            <div class="md:w-1/2">
                <!-- Gambar Bebek Dummy -->
                <img src="https://images.unsplash.com/photo-1626776876729-bab43b3501a3?q=80&w=1000&auto=format&fit=crop" alt="Bebek Goreng" class="rounded-2xl shadow-2xl border-4 border-white object-cover h-80 w-full">
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-20 px-4 max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Menu Andalan Kami</h2>
            <div class="h-1 w-20 bg-spicy mx-auto rounded"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card Menu 1 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
                <div class="h-48 bg-gray-200 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?q=80&w=800&auto=format&fit=crop" alt="Bebek Sambal Hijau" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute top-2 right-2 bg-spicy text-white text-xs font-bold px-2 py-1 rounded">Best Seller</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Bebek Protol Sambal Hijau</h3>
                    <p class="text-gray-600 text-sm mb-4">Bebek goreng kering dengan siraman sambal hijau khas Padang yang pedas gurih.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-spicy font-bold text-xl">Rp 25.000</span>
                        <button class="text-warm hover:text-orange-600 font-semibold"><i class="fa-solid fa-cart-plus"></i> Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Card Menu 2 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
                <div class="h-48 bg-gray-200 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1598514982205-f36b96d1e8d4?q=80&w=800&auto=format&fit=crop" alt="Bebek Sambal Korek" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Bebek Protol Sambal Korek</h3>
                    <p class="text-gray-600 text-sm mb-4">Bebek goreng krispi disajikan dengan sambal korek bawang yang super pedas menendang.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-spicy font-bold text-xl">Rp 27.000</span>
                        <button class="text-warm hover:text-orange-600 font-semibold"><i class="fa-solid fa-cart-plus"></i> Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Card Menu 3 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
                <div class="h-48 bg-gray-200 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1564834724105-918b73d1b9e0?q=80&w=800&auto=format&fit=crop" alt="Paket Puas" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Paket Puas (Nasi + Bebek)</h3>
                    <p class="text-gray-600 text-sm mb-4">Paket lengkap nasi putih hangat, bebek protol pilihan, tahu tempe, dan es teh manis.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-spicy font-bold text-xl">Rp 35.000</span>
                        <button class="text-warm hover:text-orange-600 font-semibold"><i class="fa-solid fa-cart-plus"></i> Pesan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="lokasi" class="bg-gray-900 text-gray-300 py-10 mt-10">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold text-white mb-4"><i class="fa-solid fa-fire mr-2 text-spicy"></i>Bebek Protol</h3>
            <p class="mb-2"><i class="fa-solid fa-location-dot mr-2"></i> Jl. Pahlawan No. 123, Surabaya, Jawa Timur</p>
            <p class="mb-6"><i class="fa-brands fa-whatsapp mr-2"></i> 0812-3456-7890</p>
            <p class="text-sm text-gray-500">&copy; 2026 UMKM Bebek Protol. Dibuat untuk Project PJBL.</p>
        </div>
    </footer>

</body>
</html>