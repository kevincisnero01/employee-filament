<?php

namespace App\Filament\Resources\SupplieResource\Pages;

use App\Filament\Resources\SupplieResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\Request;


class CreateSupplie extends CreateRecord
{
    protected static string $resource = SupplieResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
