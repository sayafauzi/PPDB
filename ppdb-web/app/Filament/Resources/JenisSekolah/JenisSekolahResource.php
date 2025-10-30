<?php

namespace App\Filament\Resources\JenisSekolah;

use App\Filament\Resources\JenisSekolah\Pages\ListJenisSekolah;
use App\Filament\Resources\JenisSekolah\Tables\JenisSekolahTable;
use App\Filament\Resources\JenisSekolah\Pages\CreateJenisSekolah;
use App\Filament\Resources\JenisSekolah\Pages\EditJenisSekolah;
use App\Filament\Resources\JenisSekolah\Schemas\JenisSekolahForm;

use App\Models\JenisSekolah;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class JenisSekolahResource extends Resource
{
    protected static ?string $model = JenisSekolah::class;
    protected static ?string $slug = 'jenis-sekolah';
    protected static string|UnitEnum|null $navigationGroup = 'Sekolah Manajemen';
    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'JenisSekolah';

    public static function form(Schema $schema): Schema
    {
        return JenisSekolahForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisSekolahTable::configure($table);
    }

    public static function getNavigationLabel(): string
    {
        return 'Jenis Sekolah'; // Nama yang ingin ditampilkan
    }

    public static function getModelLabel(): string
    {
        return 'Jenis Sekolah';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Jenis Sekolah'; // Untuk label plural
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
            'index' => ListJenisSekolah::route('/'),
            'create' => CreateJenisSekolah::route('/create'),
            'edit' => EditJenisSekolah::route('/{record}/edit'),
        ];
    }
}
