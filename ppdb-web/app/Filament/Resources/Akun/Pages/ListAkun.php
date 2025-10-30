<?php

namespace App\Filament\Resources\Akun\Pages;

use App\Filament\Resources\Akun\AkunResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAkun extends ListRecords
{
    protected static string $resource = AkunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
