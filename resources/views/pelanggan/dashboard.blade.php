<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pelanggan - Depot Wilda Fresh</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="max-w-5xl mx-auto p-6">
        <!-- Header -->
        <div class="bg-green-600 text-white rounded-lg shadow-lg p-6 mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Halo, {{ $pelanggan->nama_pelanggan }}</h1>
                <p class="mt-1 text-sm opacity-90">Selamat datang kembali di Depot Wilda Fresh!</p>
            </div>
            <form method="POST" action="{{ route('pelanggan.logout') }}">
                @csrf
                <button type="submit"
                    class="bg-white text-green-700 font-semibold px-4 py-2 rounded-lg shadow hover:bg-green-100 transition">
                    Logout
                </button>
            </form>
        </div>

        <!-- Info Kupon -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Jumlah Kupon</h2>
            <p class="text-3xl font-bold text-green-600">{{ $totalKupon }}</p>
            <p class="text-sm text-gray-500 mt-1">
                Gunakan kupon untuk mendapatkan diskon atau promo spesial.
            </p>

            @if($totalKupon == 4)
            <div class="mt-4 p-3 bg-yellow-100 border border-yellow-300 text-yellow-800 rounded">
                🎉 Selamat! Jika Anda menambah 1 kupon lagi, Anda akan mendapatkan bonus spesial!
            </div>
            @endif
        </div>


        <!-- Riwayat Transaksi -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Transaksi</h2>

            @if($transaksi->isEmpty())
            <p class="text-gray-500">Belum ada transaksi.</p>
            @else
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 text-sm">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Produk</th>
                            <th class="px-4 py-2 border">Jumlah</th>
                            <th class="px-4 py-2 border">Total Harga</th>
                            <th class="px-4 py-2 border">Metode Pembayaran</th>
                            <th class="px-4 py-2 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $t)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y') }}</td>
                            <td class="px-4 py-2 border">{{ $t->produk->nama_produk }}</td>
                            <td class="px-4 py-2 border">{{ $t->jumlah }}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border">{{ $t->motede_pembayaran ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                @if($t->is_paid)
                                <span class="text-green-600 font-semibold">Lunas</span>
                                @else
                                <span class="text-red-600 font-semibold">Belum Lunas</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

</body>

</html>