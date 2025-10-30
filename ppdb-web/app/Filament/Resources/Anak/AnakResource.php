<?php

namespace App\Filament\Resources\Anak;

use App\Filament\Resources\Anak\Pages\ListAnak;
use App\Filament\Resources\Anak\Schemas\AnakForm as SchemasAnakForm;
use App\Filament\Resources\Anak\Tables\AnakTable;
use App\Filament\Resources\Anak\Pages\CreateAnak;
use App\Filament\Resources\Anak\Pages\EditAnak;
use App\Models\Anak;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

class AnakResource extends Resource
{
    protected static ?string $model = Anak::class;
    protected static ?string $slug = 'anak';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?string $recordTitleAttribute = 'Anak';

    public static function form(Schema $schema): Schema
    {
        return SchemasAnakForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnakTable::configure($table);
    }

    public static function getNavigationLabel(): string
    {
        return 'Anak'; // Nama yang ingin ditampilkan
    }

    public static function getModelLabel(): string
    {
        return 'Anak';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Anak'; // Untuk label plural
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
            'index' => ListAnak::route('/'),
            'create' => CreateAnak::route('/create'),
            'edit' => EditAnak::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     $user = Filament::auth()->user();
    //     $query = parent::getEloquentQuery();

    //     if ($user->tipe_akun === 'SU') {
    //         return $query;
    //     }

    //     if ($user->tipe_akun === 'A') {
    //         // Admin hanya melihat anak yang mendaftar ke sekolah admin tersebut
    //         return $query->whereHas('registrasi.sekolah', function ($q) use ($user) {
    //             $q->whereHas('admins', function ($a) use ($user) {
    //                 $a->where('akun_id', $user->id);
    //             });
    //         });
    //     }

    //     if ($user->tipe_akun === 'U') {
    //         // Orang tua hanya melihat anaknya sendiri
    //         return $query->where('id_akun_orangtua', $user->id)->with(['orangTua']);
    //     }

    //     return $query;
    // }
}
