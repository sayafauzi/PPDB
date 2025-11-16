<?php

namespace App\Filament\Parent\Resources\Registrasi;

use App\Filament\Parent\Resources\Registrasi\Pages\CreateRegistrasi;
use App\Filament\Parent\Resources\Registrasi\Pages\EditRegistrasi;
use App\Filament\Parent\Resources\Registrasi\Pages\ListRegistrasi;
use App\Filament\Parent\Resources\Registrasi\Schemas\RegistrasiForm;
use App\Filament\Parent\Resources\Registrasi\Tables\RegistrasiTable;
use App\Models\Registrasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RegistrasiResource extends Resource
{
    protected static ?string $model = Registrasi::class;
    protected static ?string $slug = 'registrasi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'Registrasi';

    public static function getNavigationLabel(): string
    {
        return 'Registrasi'; // Nama yang ingin ditampilkan
    }

    public static function getModelLabel(): string
    {
        return 'Registrasi';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Registrasi'; // Untuk label plural
    }

    public static function form(Schema $schema): Schema
    {
        return RegistrasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RegistrasiTable::configure($table);
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
            'index' => ListRegistrasi::route('/'),
            'create' => CreateRegistrasi::route('/create'),
            'edit' => EditRegistrasi::route('/{record}/edit'),
        ];
    }
}
