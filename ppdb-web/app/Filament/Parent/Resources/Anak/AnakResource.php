<?php

namespace App\Filament\Parent\Resources\Anak;

use App\Filament\Parent\Resources\Anak\Pages\CreateAnak;
use App\Filament\Parent\Resources\Anak\Pages\EditAnak;
use App\Filament\Parent\Resources\Anak\Pages\ListAnak;
use App\Filament\Parent\Resources\Anak\Schemas\AnakForm;
use App\Filament\Parent\Resources\Anak\Tables\AnakTable;
use App\Models\Anak;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AnakResource extends Resource
{
    protected static ?string $model = Anak::class;
    protected static ?string $slug = 'anak';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Anak';

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

    public static function form(Schema $schema): Schema
    {
        return AnakForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnakTable::configure($table);
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        // Jika user yang sedang login adalah Tipe U (Orang Tua),
        // paksa id_akun_orangtua diisi dengan ID-nya sendiri.
        if (Auth::user()->tipe_akun === 'U') {
            $data['id_akun_orangtua'] = Auth::id();
        }
        
        // Jika user adalah Admin/Super Admin, biarkan nilai diambil dari form,
        // yang mana dijamin terisi karena required(true) di frontend.
        
        return $data;
    }

    // Lakukan hal yang sama untuk update jika diperlukan
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (Auth::user()->tipe_akun === 'U') {
            $data['id_akun_orangtua'] = Auth::id();
        }
        return $data;
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
}
