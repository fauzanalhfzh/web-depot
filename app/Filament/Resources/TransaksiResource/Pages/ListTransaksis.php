<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use App\Filament\Resources\TransaksiResource\Widgets\TransaksiChart;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;


class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ActionGroup::make([
                Action::make('Harian')
                    ->label('Laporan Harian')
                    ->icon('heroicon-o-calendar')
                    ->url(route('laporan.transaksi', ['periode' => 'harian']))
                    ->openUrlInNewTab(),

                Action::make('Mingguan')
                    ->label('Laporan Mingguan')
                    ->icon('heroicon-o-calendar')
                    ->url(route('laporan.transaksi', ['periode' => 'mingguan']))
                    ->openUrlInNewTab(),

                Action::make('Bulanan')
                    ->label('Laporan Bulanan')
                    ->icon('heroicon-o-calendar')
                    ->url(route('laporan.transaksi', ['periode' => 'bulanan']))
                    ->openUrlInNewTab(),

                Action::make('Tahunan')
                    ->label('Laporan Tahunan')
                    ->icon('heroicon-o-calendar')
                    ->url(route('laporan.transaksi', ['periode' => 'tahunan']))
                    ->openUrlInNewTab(),
            ])
                ->label('Cetak Laporan')
                ->icon('heroicon-o-printer')
                ->color('primary')
                ->button(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TransaksiChart::class,
        ];
    }
}
