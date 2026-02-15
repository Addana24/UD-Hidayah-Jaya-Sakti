<?php

namespace App\Filament\Exports;

use App\Models\Transaction;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TransactionExporter extends Exporter
{
    protected static ?string $model = Transaction::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('product.name')
                ->label('Produk'),
            ExportColumn::make('supplier.name')
                ->label('Supplier'),
            ExportColumn::make('type')
                ->label('Jenis'),
            ExportColumn::make('occurred_at')
                ->label('Tanggal'),
            ExportColumn::make('quantity')
                ->label('Jumlah'),
            ExportColumn::make('unit_price')
                ->label('Harga Satuan'),
            ExportColumn::make('notes')
                ->label('Catatan'),
            // ExportColumn::make('created_at')
            //     ->label('Dibuat pada'),
            // ExportColumn::make('updated_at')
            //     ->label('Diperbarui pada'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor transaksi telah selesai dan ' . number_format($export->successful_rows) . ' dari ' . number_format($export->total_rows) . ' baris berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal diekspor.';
        }

        return $body;
    }
}
