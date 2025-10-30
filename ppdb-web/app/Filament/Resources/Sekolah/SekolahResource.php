<?php

namespace App\Filament\Resources\Sekolah;

use App\Filament\Resources\Sekolah\Pages\CreateSekolah;
use App\Filament\Resources\Sekolah\Pages\EditSekolah;
use App\Filament\Resources\Sekolah\Pages\ListSekolah;
use App\Filament\Resources\Sekolah\Schemas\SekolahForm;
use App\Filament\Resources\Sekolah\Tables\SekolahTable;
use App\Models\Sekolah;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class SekolahResource extends Resource
{
    protected static ?string $model = Sekolah::class;
    protected static ?string $slug = 'sekolah';
    protected static string|UnitEnum|null $navigationGroup = 'Sekolah Manajemen';
    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'Sekolah';

    public static function form(Schema $schema): Schema
    {
        return SekolahForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SekolahTable::configure($table);
    }

    public static function getNavigationLabel(): string
    {
        return 'Sekolah'; // Nama yang ingin ditampilkan
    }

    public static function getModelLabel(): string
    {
        return 'Sekolah';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Sekolah'; // Untuk label plural
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
            'index' => ListSekolah::route('/'),
            'create' => CreateSekolah::route('/create'),
            'edit' => EditSekolah::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        // SuperAdmin → semua sekolah
        if ($user->tipe_akun === 'SU') {
            return $query;
        }

        // Admin → hanya sekolah yang diassign di akun_sekolah
        if ($user->tipe_akun === 'A') {
            return $query->whereHas('akunSekolah', function ($q) use ($user) {
                $q->where('akun_id', $user->id);
            });
        }

        // Orang Tua → tidak punya akses
        return $query->whereRaw('1=0');
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
