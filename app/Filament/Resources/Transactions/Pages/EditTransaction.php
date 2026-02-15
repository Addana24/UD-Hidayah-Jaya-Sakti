<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function afterSave(): void
    {
        // Recalculate stok berdasarkan perbedaan quantity lama dan baru
        $record = $this->record; // App\Models\Transaction
        $product = $record->product;
        if (! $product) {
            return;
        }

        // Ambil nilai asli dari database sebelum perubahan
        $original = $record->getOriginal();
        $oldQuantity = (float) ($original['quantity'] ?? 0);
        $oldType = $original['type'] ?? null;

        $newQuantity = (float) $record->quantity;
        $newType = $record->type;

        // Jika type berubah, kita perlu mengembalikan efek lama lalu menerapkan efek baru
        if ($oldType !== $newType) {
            // rollback efek lama
            if ($oldType === 'in') {
                $product->decrement('stock', $oldQuantity);
            } elseif ($oldType === 'out') {
                $product->increment('stock', $oldQuantity);
            }
            // terapkan efek baru
            if ($newType === 'in') {
                $product->increment('stock', $newQuantity);
            } elseif ($newType === 'out') {
                $product->decrement('stock', $newQuantity);
            }
            return;
        }

        // Jika type sama, cukup hitung selisih quantity
        $delta = $newQuantity - $oldQuantity;
        if ($delta === 0.0) {
            return;
        }
        if ($newType === 'in') {
            $product->increment('stock', $delta);
        } elseif ($newType === 'out') {
            $product->decrement('stock', $delta);
        }
    }
}

