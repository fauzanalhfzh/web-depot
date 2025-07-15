<?php

namespace App\Filament\Resources\PelangganResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiRelationManager extends RelationManager
{
    protected static string $relationship = 'transaksi';

    protected static ?string $title = 'Riwayat Transaksi';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal_transaksi')
                    ->required(),
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $pelangganId = $this->getOwnerRecord()->id;

                        if (!$pelangganId) {
                            $set('bonus', 0);
                            return;
                        }

                        // Hitung total pembelian sebelum transaksi ini
                        $totalJumlahPembelianSebelumnya = \App\Models\Transaksi::where('pelanggan_id', $pelangganId)->sum('jumlah');

                        // Hitung total pembelian termasuk transaksi ini
                        $totalJumlahPembelianSekarang = $totalJumlahPembelianSebelumnya + ($state ?? 0);

                        // Hitung bonus sebelum transaksi ini
                        $bonusSebelumnya = floor($totalJumlahPembelianSebelumnya / 5);

                        // Hitung bonus sekarang
                        $bonusSekarang = floor($totalJumlahPembelianSekarang / 5);

                        // Bonus tambahan hanya jika bonus sekarang lebih besar dari bonus sebelumnya
                        $bonus = $bonusSekarang > $bonusSebelumnya ? ($bonusSekarang - $bonusSebelumnya) : 0;

                        $set('bonus', $bonus);

                        // Hitung total harga
                        $hargaGalon = 5000;
                        if ($state) {
                            $set('total_harga', $state * $hargaGalon);
                        } else {
                            $set('total_harga', 0);
                        }
                    }),
                Forms\Components\TextInput::make('total_harga')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('bonus')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('transaksi')
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_transaksi')->date(),
                Tables\Columns\TextColumn::make('jumlah')->numeric(),
                Tables\Columns\TextColumn::make('total_harga')->numeric(),
                Tables\Columns\TextColumn::make('bonus')->numeric(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
