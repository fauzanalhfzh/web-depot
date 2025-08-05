<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TransaksiChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Transaksi per Bulan';

    protected function getData(): array
    {
        $tahun = now()->year;

        $data = Transaksi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Buat array bulan dari Jan - Dec
        $labels = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        $monthlyTotals = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyTotals[] = $data->get($i, 0);
        }

        return [
            'datasets' => [
                [
                    'label' => "Total Transaksi Tahun $tahun",
                    'data' => $monthlyTotals,
                    'backgroundColor' => '#3b82f6',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    public function getColumnSpan(): int | string | array
    {
        return 'full'; // ⬅️ Ini yang bikin chart tampil full lebar
    }
}
