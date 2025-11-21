<?php

namespace App\Filament\Resources\Akun;

use App\Filament\Resources\Akun\Pages\CreateAkun;
use App\Filament\Resources\Akun\Pages\EditAkun;
use App\Filament\Resources\Akun\Pages\ListAkun;
use App\Filament\Resources\Akun\Schemas\AkunForm;
use App\Filament\Resources\Akun\Tables\AkunTable;
use App\Models\Akun;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class AkunResource extends Resource
{
    protected static ?string $model = Akun::class;
    protected static ?string $slug = 'akun';
    protected static string|UnitEnum|null $navigationGroup = 'Akun Manajemen';
    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'Akun';

    public static function form(Schema $schema): Schema
    {
        return AkunForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AkunTable::configure($table);
    }

    public static function getNavigationLabel(): string
    {
        return 'Akun'; // Nama yang ingin ditampilkan
    }

    public static function getModelLabel(): string
    {
        return 'Akun';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Akun'; // Untuk label plural
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
            'index' => ListAkun::route('/'),
            'create' => CreateAkun::route('/create'),
            'edit' => EditAkun::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->tipe_akun !== 'A';
    }
}
