<?php

namespace App\Filament\Resources\JenisSekolah\Pages;

use App\Filament\Resources\JenisSekolah\JenisSekolahResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJenisSekolah extends ListRecords
{
    protected static string $resource = JenisSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
