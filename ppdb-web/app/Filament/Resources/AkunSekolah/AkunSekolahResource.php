<?php

namespace App\Filament\Resources\AkunSekolah;

use App\Filament\Resources\AkunSekolah\Pages\CreateAkunSekolah;
use App\Filament\Resources\AkunSekolah\Pages\EditAkunSekolah;
use App\Filament\Resources\AkunSekolah\Pages\ListAkunSekolah;
use App\Filament\Resources\AkunSekolah\Schemas\AkunSekolahForm;
use App\Filament\Resources\AkunSekolah\Tables\AkunSekolahTable;
use App\Models\AkunSekolah;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class AkunSekolahResource extends Resource
{
    protected static ?string $model = AkunSekolah::class;
    protected static ?string $slug = 'akun-sekolah';
    protected static string|UnitEnum|null $navigationGroup = 'Sekolah Manajemen';
    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?string $recordTitleAttribute = 'AkunSekolah';

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return in_array($user->tipe_akun, ['SU', 'A']); // hanya SuperAdmin & Admin
    }

    public static function form(Schema $schema): Schema
    {
        return AkunSekolahForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AkunSekolahTable::configure($table);
    }

    public static function getNavigationLabel(): string
    {
        return 'Akun Sekolah'; // Nama yang ingin ditampilkan
    }

    public static function getModelLabel(): string
    {
        return 'Akun Sekolah';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Akun Sekolah'; // Untuk label plural
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
            'index' => ListAkunSekolah::route('/'),
            'create' => CreateAkunSekolah::route('/create'),
            'edit' => EditAkunSekolah::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Filament::auth()->user();
        $query = parent::getEloquentQuery();

        if ($user->tipe_akun === 'SU') {
            return $query;
        }

        if ($user->tipe_akun === 'A') {
            // Admin hanya melihat sekolah tempat dia terdaftar
            return $query->where('akun_id', $user->id);
        }

        // Orang tua tidak perlu melihat tabel ini
        return $query->whereRaw('1=0');
    }
}
