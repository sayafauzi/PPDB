<?php

namespace App\Filament\Resources\Sekolah\Schemas;

use App\Models\JenisSekolah;
use App\Models\Sekolah;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SekolahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Section::make('Data Sekolah')
                    ->schema([
                        TextInput::make('kode_sekolah')
                            ->label('Kode Sekolah')
                            ->required()
                            ->unique(Sekolah::class, 'kode_sekolah', ignoreRecord: true),

                        TextInput::make('nama_sekolah')
                            ->label('Nama Sekolah')
                            ->required(),


                       Section::make('Jenis Sekolah di Bawah Naungan')
                            ->description('Tambahkan satu atau lebih jenis sekolah yang dikelola oleh sekolah ini.')
                            ->schema([
                                Select::make('jenis_sekolah_id')
                                    ->label('Jenis Sekolah')
                                    ->relationship('jenisSekolah', 'nama_jenis')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->hint('Pilih jenis sekolah yang sudah ada'),
                            ])
                            ->collapsed(false)
                            ->columns(1)
                            ->columnSpanFull(),

                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(3),

                        TextInput::make('kontak')
                            ->label('Kontak')
                            ->tel(),

                        Toggle::make('status_aktif')
                            ->label('Status Aktif')
                            ->default(true),
                    ])->columns(2)->columnSpanFull(),
                
                Section::make('Rekening & Biaya')
                    ->schema([
                        TextInput::make('nama_rekening')
                            ->label('Nama Rekening'),
                        TextInput::make('no_rekening')
                            ->label('Nomor Rekening'),
                        TextInput::make('link_grup')
                            ->label('Link Grup WA / Info'),

                        TextInput::make('biaya_pendaftaran')
                            ->numeric()->default(0),
                        TextInput::make('biaya_awal')
                            ->numeric()->default(0),
                        TextInput::make('biaya_spp')
                            ->numeric()->default(0),
                    ])->columns(3),

                Section::make('Syarat Pendaftaran')
                    ->schema([
                        Textarea::make('syarat')
                            ->label('Syarat & Ketentuan')
                            ->rows(4),
                    ]),
            ]);
    }
}
