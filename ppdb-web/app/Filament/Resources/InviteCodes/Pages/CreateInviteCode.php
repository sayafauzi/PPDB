<?php

namespace App\Filament\Resources\InviteCodes\Pages;

use App\Filament\Resources\InviteCodes\InviteCodeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInviteCode extends CreateRecord
{
    protected static string $resource = InviteCodeResource::class;
}
