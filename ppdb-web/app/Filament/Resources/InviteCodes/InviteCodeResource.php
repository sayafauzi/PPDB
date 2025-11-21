<?php

namespace App\Filament\Resources\InviteCodes;

use App\Filament\Resources\InviteCodes\Pages\CreateInviteCode;
use App\Filament\Resources\InviteCodes\Pages\EditInviteCode;
use App\Filament\Resources\InviteCodes\Pages\ListInviteCodes;
use App\Filament\Resources\InviteCodes\Schemas\InviteCodeForm;
use App\Filament\Resources\InviteCodes\Tables\InviteCodesTable;
use App\Models\InviteCode;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class InviteCodeResource extends Resource
{
    protected static ?string $model = InviteCode::class;
    protected static ?string $slug = 'invite-code';
    protected static string|UnitEnum|null $navigationGroup = 'Akun Manajemen';
    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $recordTitleAttribute = 'InviteCode';

    public static function form(Schema $schema): Schema
    {
        return InviteCodeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InviteCodesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInviteCodes::route('/'),
            'create' => CreateInviteCode::route('/create'),
            'edit' => EditInviteCode::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();

        return $user && in_array($user->tipe_akun, ['SU']);
    }
}
