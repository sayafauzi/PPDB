<?php

namespace App\Filament\Resources\AkunSekolah\Pages;

use App\Filament\Resources\AkunSekolah\AkunSekolahResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAkunSekolah extends ListRecords
{
    protected static string $resource = AkunSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
