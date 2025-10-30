<?php

namespace App\Filament\Parent\Resources\Anak\Pages;

use App\Filament\Parent\Resources\Anak\AnakResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAnak extends EditRecord
{
    protected static string $resource = AnakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
