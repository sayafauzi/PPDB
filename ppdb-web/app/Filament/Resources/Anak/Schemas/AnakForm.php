<?php

namespace App\Filament\Resources\Anak\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class AnakForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Orang Tua')
                ->schema([
                    Select::make('id_akun_orangtua')
                        ->label('Orang Tua')
                        ->relationship('akun', 'name')
                        ->searchable()
                        ->visible(fn() => auth::user()->tipe_akun !== 'U') // hanya admin/superadmin bisa memilih manual
                        ->required(fn() => auth::user()->tipe_akun !== 'U'|| 'SU')
                        ->default(fn() => auth::user()->tipe_akun === 'U' || 'SU' ? auth::id() : null)
                        ->required(),
                ]),

                Section::make('Data Anak')
                ->columns(2)
                ->schema([
                    TextInput::make('nama_lengkap')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(100),

                    TextInput::make('tempat_lahir')->required(),

                    DatePicker::make('tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->required(),

                    Select::make('jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                        ->required(),

                    TextInput::make('agama')->maxLength(50),
                    TextInput::make('kewarganegaraan')->maxLength(50),
                    TextInput::make('nik')
                        ->label('NIK')
                        ->unique(ignoreRecord: true)
                        ->required(),
                    TextInput::make('no_kk')
                        ->label('No. KK')
                        ->unique(ignoreRecord: true)
                        ->required(),
                    TextInput::make('no_akta_lahir')->label('No. Akta Lahir'),
                ]),

                Section::make('Data Sekolah & Prestasi')
                ->columns(2)
                ->schema([
                    TextInput::make('asal_sekolah')
                        ->label('Asal Sekolah')
                        ->maxLength(150),
                    TextInput::make('rerata_rapor')
                        ->numeric()
                        ->label('Rata-rata Rapor')
                        ->step(0.01)
                        ->suffix('%'),
                    Textarea::make('prestasi')
                        ->rows(3)
                        ->label('Prestasi Akademik/Non-Akademik'),
                ]),

                Section::make('Data Tempat Tinggal')
                ->columns(2)
                ->schema([
                    TextInput::make('tempat_tinggal')->label('Tempat Tinggal')->maxLength(150),
                    TextInput::make('moda_transportasi')->label('Transportasi'),
                    TextInput::make('jarak_rumah')->numeric()->label('Jarak Rumah (km)'),
                    TextInput::make('anak_ke')->numeric()->label('Anak ke-'),
                ]),

            ]);
    }
}
