@php
use Carbon\Carbon;

setlocale(LC_TIME, 'id_ID');
Carbon::setLocale('id');

$hariIni = Carbon::now()->isoFormat('dddd, D MMMM Y');
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        p {
            margin: 0 0 10px 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Laporan Transaksi {{ ucfirst($periode) }}</h2>

    <p><strong>Jenis Laporan:</strong>
        @switch($periode)
        @case('harian') Harian @break
        @case('mingguan') Mingguan @break
        @case('bulanan') Bulanan @break
        @case('tahunan') Tahunan @break
        @default -
        @endswitch
    </p>

    @if(isset($startDate) && isset($endDate))
    <p><strong>Periode:</strong> {{ $startDate->translatedFormat('d F Y') }} - {{ $endDate->translatedFormat('d F Y') }}</p>
    @endif

    <p><strong>Tanggal Cetak:</strong> {{ $hariIni }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($data->tanggal_transaksi)->format('d-m-Y') }}</td>
                <td>{{ $data->pelanggan->nama_pelanggan }}</td>
                <td>{{ $data->produk->nama_produk }}</td>
                <td>{{ $data->jumlah }}</td>
                <td>Rp {{ number_format($data->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5" align="right" class="total">Total</td>
                <td class="total">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>