<?php

namespace App\Filament\Widgets;

use App\Models\Pelanggan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PelangganStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPelanggan = Pelanggan::count();
        $pelangganHariIni = Pelanggan::whereDate('created_at', now()->toDateString())->count();
        $pelangganTerhapus = Pelanggan::onlyTrashed()->count();

        return [
            Stat::make('Total Pelanggan', $totalPelanggan)
                ->description('Jumlah seluruh pelanggan yang terdaftar')
                ->color('success'),

            Stat::make('Pelanggan Hari Ini', $pelangganHariIni)
                ->description('Pendaftaran pelanggan baru hari ini')
                ->color('info'),

            Stat::make('Pelanggan Terhapus', $pelangganTerhapus)
                ->description('Data pelanggan yang dihapus sementara')
                ->color('danger'),
        ];
    }
}
