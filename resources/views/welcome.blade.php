<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Depot Wilda Fresh</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-[#f9fafb] text-[#1b1b18] font-sans">

    <!-- Navbar -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-green-600">Depot Wilda Fresh</h1>
            <a href="#lokasi" class="text-green-700 hover:underline font-medium">Alamat Kami</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-green-50 py-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-green-800 mb-4">Air Galon Sehat & Terjangkau</h2>
            <p class="text-lg text-gray-600 mb-6">Pesan air galon isi ulang langsung ke rumah Anda, praktis dan cepat!</p>
            <a href="#produk" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                Lihat Produk
            </a>
        </div>
    </section>

    <!-- Tentang Kami Section - Futuristik Overlap -->
    <section class="relative bg-white py-24" id="tentang-kami">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center px-6">
            <!-- Gambar besar -->
            <div class="relative">
                <img src="{{ asset('images/depot.png') }}"
                    alt="Depot Wilda Fresh"
                    class="w-full h-full object-cover rounded-3xl shadow-xl">
            </div>

            <!-- Konten yang overlapping -->
            <div class="relative md:-ml-20 z-10 bg-white/80 backdrop-blur-xl p-8 rounded-3xl shadow-lg">
                <h3 class="text-4xl font-extrabold text-gray-800 mb-4">Tentang Depot Wilda Fresh</h3>
                <p class="text-gray-700 text-lg leading-relaxed">
                    Kami adalah penyedia air isi ulang terpercaya di Cilegon. Mengutamakan kualitas dan kebersihan,
                    kami menyediakan galon air yang sehat dan siap antar ke rumah Anda. Layanan cepat, harga bersahabat.
                </p>
            </div>
        </div>
    </section>

    <!-- Produk Section -->
    <main id="produk" class="max-w-7xl mx-auto px-6 py-12">
        <h3 class="text-2xl font-bold mb-6 text-gray-800">Produk Kami</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($produks as $produk)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('storage/' . $produk->gambar_produk) }}"
                    alt="{{ $produk->nama_produk }}"
                    class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $produk->nama_produk }}</h2>
                    <p class="text-green-600 font-bold mt-1">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20memesan%20{{ urlencode($produk->nama_produk) }}"
                        class="block mt-4 bg-green-500 hover:bg-green-600 text-white text-center py-2 rounded-md transition"
                        target="_blank">
                        Pesan via WhatsApp
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <!-- Lokasi Section -->
    <section id="lokasi" class="bg-white py-16">
        <div class="max-w-5xl mx-auto px-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Alamat Kami</h3>
            <p class="text-center text-gray-600 mb-6">Kunjungi Depot Wilda Fresh atau cek lokasi kami melalui peta di bawah ini.</p>
            <div class="w-full h-96 rounded-lg overflow-hidden shadow-lg">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.9488089141532!2d106.06534667593402!3d-6.001767758962415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e418e12ec0734f3%3A0xdd47e111a5020546!2sSTTIKOM%20Insan%20Unggul!5e0!3m2!1sen!2sid!4v1753749658588!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 text-center py-6 text-sm text-gray-600">
        &copy; {{ date('Y') }} Depot Wilda Fresh. Semua Hak Dilindungi.
    </footer>

    <button id="backToTopBtn"
        class="fixed bottom-6 right-6 z-50 p-3 rounded-full bg-green-600 text-white shadow-lg hover:bg-green-700 transition-opacity opacity-0 pointer-events-none">
        ↑
    </button>

    <script>
        const backToTopBtn = document.getElementById('backToTopBtn');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                backToTopBtn.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>


</body>

</html>