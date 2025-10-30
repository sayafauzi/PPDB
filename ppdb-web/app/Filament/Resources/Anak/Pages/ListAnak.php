<?php

namespace App\Filament\Resources\Anak\Pages;

use App\Filament\Resources\Anak\AnakResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAnak extends ListRecords
{
    protected static string $resource = AnakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
