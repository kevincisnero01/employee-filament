<?php

namespace App\Filament\Resources\SupplieResource\Pages;

use App\Filament\Resources\SupplieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupplie extends EditRecord
{
    protected static string $resource = SupplieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
