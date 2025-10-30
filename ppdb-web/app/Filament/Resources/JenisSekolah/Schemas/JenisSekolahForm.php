<?php

namespace App\Filament\Resources\JenisSekolah\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class JenisSekolahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Jenis Sekolah')
                    ->description('Lengkapi data jenis sekolah.')
                    ->schema([
                        TextInput::make('kode_jenis')
                            ->label('Kode Jenis')
                            ->placeholder('Contoh: JD-SD, JD-SMP')
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('nama_jenis')
                            ->label('Nama Jenis Sekolah')
                            ->required(),
                        // Select::make('nama_jenis')
                        //     ->label('Nama Jenis Sekolah')
                        //     ->relationship('sekolah', 'nama_sekolah')
                        //     ->required()
                        //     ->searchable()
                        //     ->preload(),

                        TextInput::make('kuota')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->label('Kuota Awal'),

                        TextInput::make('sisa_kuota')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->label('Sisa Kuota'),

                        TextInput::make('kapasitas')
                            ->numeric()
                            ->default(0)
                            ->label('Kapasitas Total'),

                        Toggle::make('status_aktif')
                            ->label('Aktifkan Jenis Sekolah')
                            ->default(true),
                    ])->columns(2),

                        Select::make('akun_id')
                            ->label('Dibuat oleh Akun')
                            ->relationship('akun', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => auth::id())
                            ->disabled(fn () => auth::user()?->tipe_akun !== 'SU')
                            ->visible(fn () => auth::user()?->tipe_akun === 'SU')
                            ->helperText('Otomatis terisi dengan akun yang login.'),
                   
            ]);
    }
}
