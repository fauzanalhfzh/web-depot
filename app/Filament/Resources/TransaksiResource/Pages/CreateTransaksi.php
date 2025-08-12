<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use App\Models\Produk;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $produk = \App\Models\Produk::find($data['produk_id']);

        $jumlah = $data['jumlah'] ?? 0;
        $bonus  = $data['bonus'] ?? 0;
        $totalKeluar = $jumlah + $bonus;

        if ($produk && $totalKeluar > 0) {
            $produk->decrement('stok', $totalKeluar);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
