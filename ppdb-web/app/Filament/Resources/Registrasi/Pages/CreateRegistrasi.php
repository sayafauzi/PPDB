<?php

namespace App\Filament\Resources\Registrasi\Pages;

use App\Filament\Resources\Registrasi\RegistrasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRegistrasi extends CreateRecord
{
    protected static string $resource = RegistrasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
