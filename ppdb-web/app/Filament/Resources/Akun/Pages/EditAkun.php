<?php

namespace App\Filament\Resources\Akun\Pages;

use App\Filament\Resources\Akun\AkunResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAkun extends EditRecord
{
    protected static string $resource = AkunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
