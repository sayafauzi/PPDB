<?php

namespace App\Filament\Parent\Resources\Registrasi\Pages;

use App\Filament\Parent\Resources\Registrasi\RegistrasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRegistrasi extends EditRecord
{
    protected static string $resource = RegistrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
