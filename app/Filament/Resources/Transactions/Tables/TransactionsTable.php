<?php

namespace App\Filament\Resources\Transactions\Tables;

use App\Filament\Exports\TransactionExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable(),
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->label('Jenis'),
                TextColumn::make('occurred_at')
                    ->dateTime()
                    ->label('Tanggal')
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->label('Jumlah')
                    ->sortable(),
                TextColumn::make('unit_price')
                    ->money('IDR')
                    ->label('Harga Satuan')
                    ->sortable(),
                TextColumn::make('notes')
                    ->label('Catatan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Bisa ditambahkan filter jenis (in/out) dan rentang tanggal di sini jika diperlukan
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Ekspor')
                    ->exporter(TransactionExporter::class),
            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->label('Ekspor Terpilih')
                    ->exporter(TransactionExporter::class),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
