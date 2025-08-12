<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Nota Pembelian</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>

<body>

    <h2 style="text-align:center;">Depot Wilda Fresh</h2>
    <p style="text-align:center;">Jl. Contoh No. 123, Kota</p>
    <hr>

    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}</p>
    <p><strong>No. Nota:</strong> {{ $transaksi->id }}</p>
    <p><strong>Pelanggan:</strong> {{ $transaksi->pelanggan->nama_pelanggan }}</p>
    <p><strong>Kontak:</strong> {{ $transaksi->pelanggan->kontak_pelanggan }}</p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $transaksi->produk->nama_produk }}</td>
                <td>{{ $transaksi->jumlah }}</td>
                <td>Rp {{ number_format($transaksi->produk->harga, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    @if($transaksi->bonus)
    <p><strong>Bonus:</strong> {{ $transaksi->bonus }}</p>
    @endif

    @if($transaksi->is_delivery)
    <p><strong>Alamat Pengiriman:</strong> {{ $transaksi->alamat_pengiriman }}</p>
    <p><strong>Ongkir:</strong> Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</p>
    @endif

    <hr>
    <p style="text-align:right;"><strong>Total Bayar: </strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
    <p style="text-align:center; margin-top: 40px;">Terima kasih telah berbelanja di Depot Wilda Fresh!</p>

</body>

</html>