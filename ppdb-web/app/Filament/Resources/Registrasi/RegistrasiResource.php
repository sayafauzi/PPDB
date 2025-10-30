<?php

namespace App\Filament\Resources\Registrasi;

use App\Filament\Resources\Registrasi\Pages\CreateRegistrasi;
use App\Filament\Resources\Registrasi\Pages\EditRegistrasi;
use App\Filament\Resources\Registrasi\Pages\ListRegistrasi;
use App\Filament\Resources\Registrasi\Schemas\RegistrasiForm;
use App\Filament\Resources\Registrasi\Tables\RegistrasiTable;
use App\Models\Registrasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;

class RegistrasiResource extends Resource
{
    protected static ?string $model = Registrasi::class;
    protected static ?string $slug = 'registrasi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?string $recordTitleAttribute = 'Registrasi';

    public static function form(Schema $schema): Schema
    {
        return RegistrasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RegistrasiTable::configure($table);
    }

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

    public static function getEloquentQuery(): Builder
{
    $user = Filament::auth()->user();
    $query = parent::getEloquentQuery();

    if ($user->tipe_akun === 'SU') {
        return $query;
    }

    if ($user->tipe_akun === 'A') {
        // Admin hanya bisa melihat registrasi ke sekolah-nya
        return $query->whereHas('sekolah.akunSekolah', function ($q) use ($user) {
            $q->where('akun_id', $user->id);
        });
    }

    if ($user->tipe_akun === 'U') {
        // Orang tua hanya melihat registrasi anaknya
        return $query->whereHas('anak', function ($q) use ($user) {
            $q->where('id_akun_orangtua', $user->id);
        });
    }

    return $query;
}
}
