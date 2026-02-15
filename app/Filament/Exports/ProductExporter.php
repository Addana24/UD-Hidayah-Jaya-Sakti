<?php

namespace App\Filament\Exports;

use App\Models\Product;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')
                ->label('Kode'),
            ExportColumn::make('name')
                ->label('Nama Produk'),
            ExportColumn::make('category.name')
                ->label('Kategori'),
            ExportColumn::make('unit.name')
                ->label('Satuan'),
            ExportColumn::make('supplier.name')
                ->label('Supplier'),
            ExportColumn::make('purchase_price')
                ->label('Harga Beli'),
            ExportColumn::make('sale_price')
                ->label('Harga Jual'),
            ExportColumn::make('stock')
                ->label('Stok'),
            ExportColumn::make('min_stock')
                ->label('Stok Minimal'),
            ExportColumn::make('created_at')
                ->label('Dibuat pada'),
            ExportColumn::make('updated_at')
                ->label('Diperbarui pada'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor produk telah selesai dan ' . number_format($export->successful_rows) . ' dari ' . number_format($export->total_rows) . ' baris berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal diekspor.';
        }

        return $body;
    }
}