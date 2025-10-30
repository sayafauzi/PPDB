<?php

namespace App\Filament\Resources\JenisSekolah\Pages;

use App\Filament\Resources\JenisSekolah\JenisSekolahResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJenisSekolah extends EditRecord
{
    protected static string $resource = JenisSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
