<?php

namespace App\Filament\Resources\Registrasi\Pages;

use App\Filament\Resources\Registrasi\RegistrasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRegistrasi extends ListRecords
{
    protected static string $resource = RegistrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
