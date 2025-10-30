<?php

namespace App\Filament\Resources\InviteCodes\Pages;

use App\Filament\Resources\InviteCodes\InviteCodeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInviteCode extends EditRecord
{
    protected static string $resource = InviteCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
