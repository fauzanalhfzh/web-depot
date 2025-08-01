<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $label = "Transaksi";

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pelanggan_id')
                    ->label('Nama Pelanggan')
                    ->relationship('pelanggan', 'nama_pelanggan')
                    ->searchable()
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('produk_id')
                    ->label('Produk')
                    ->relationship('produk', 'nama_produk')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_transaksi')
                    ->maxDate(Carbon::today())
                    ->required(),
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $pelangganId = $get('pelanggan_id');

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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelanggan.nama_pelanggan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_transaksi')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bonus')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'view' => Pages\ViewTransaksi::route('/{record}'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
