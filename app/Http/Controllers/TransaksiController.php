<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class TransaksiController extends Controller
{
    public function cetakTransaksi($periode)
    {
        $tanggal = now();
        $query = Transaksi::with('pelanggan', 'produk');

        switch ($periode) {
            case 'harian':
                $query->whereDate('tanggal_transaksi', $tanggal);
                break;
            case 'mingguan':
                $query->whereBetween('tanggal_transaksi', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'bulanan':
                $query->whereMonth('tanggal_transaksi', $tanggal->month)
                    ->whereYear('tanggal_transaksi', $tanggal->year);
                break;
            case 'tahunan':
                $query->whereYear('tanggal_transaksi', $tanggal->year);
                break;
        }

        $transaksi = $query->get();
        $total = $transaksi->sum('total_harga');

        $html = view('laporan.transaksi', compact('transaksi', 'periode', 'total'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output("Laporan_Transaksi_{$periode}.pdf", 'I');
    }
}
