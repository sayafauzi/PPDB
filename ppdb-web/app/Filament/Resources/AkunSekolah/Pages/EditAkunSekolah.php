<?php

namespace App\Filament\Resources\AkunSekolah\Pages;

use App\Filament\Resources\AkunSekolah\AkunSekolahResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAkunSekolah extends EditRecord
{
    protected static string $resource = AkunSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
