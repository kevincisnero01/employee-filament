<?php

namespace App\Filament\Resources\SupplieResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SupplieResource;

class ListSupplies extends ListRecords
{
    protected static string $resource = SupplieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Crear Suministro'),
        ];
    }
}
