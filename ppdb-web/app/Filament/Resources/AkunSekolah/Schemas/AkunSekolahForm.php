<?php

namespace App\Filament\Resources\AkunSekolah\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\TextInput;
use Filament\Schemas\Schema;

class AkunSekolahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
            Section::make('Informasi Akun Sekolah')
                ->schema([
                    Select::make('akun_id')
                        ->label('Akun')
                        ->relationship('akun', 'name') // pastikan kolom `nama` ada di tabel `akun`
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('sekolah_id')
                        ->label('Sekolah')
                        ->relationship('sekolah', 'nama_sekolah') // pastikan kolom `nama_sekolah` ada di tabel `sekolah`
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('role_in_school')
                        ->label('Peran di Sekolah')
                        ->options([
                            'admin' => 'Admin Sekolah',
                            'panitia' => 'Panitia PPDB',
                        ])
                        ->default('panitia')
                        ->required(),
                ])
                ->columns(3),
        ]);
    }
}
