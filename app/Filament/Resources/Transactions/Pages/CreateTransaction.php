<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record; // App\Models\Transaction
        $product = $record->product; // relasi belongsTo
        if ($product) {
            if ($record->type === 'in') {
                $product->increment('stock', (float) $record->quantity);
            } elseif ($record->type === 'out') {
                $product->decrement('stock', (float) $record->quantity);
            }
        }
    }
}

