<?php

namespace App\Filament\Resources\Akun\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class AkunForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required(),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required(),

                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn($state) => filled($state))
                            ->visible(fn($context) => $context === 'edit' || $context === 'create')
                            ->label('Password'),
                        
                        // Component tipe_akun dipindahkan ke dalam section ini, 
                        // karena Anda mencoba menempatkan options dan label 'Peran'
                        // langsung di Section, yang salah.
                        Select::make('tipe_akun')
                            ->label('Peran') // Label yang diinginkan
                            ->options([
                                'SU' => 'Super Admin',
                                'A' => 'Admin Sekolah',
                                'U' => 'Orang Tua',
                            ])
                            ->default('U')
                            ->required()
                            ->dehydrated(true),


                    ])
                    ->columns(2),  

                Section::make('Lokasi dan Sekolah')
                    ->schema([
                        TextInput::make('kelurahan'),
                        TextInput::make('kecamatan'),

                        Select::make('sekolah')
                            ->multiple()
                            ->relationship('sekolah', 'nama_sekolah')
                            ->visible(fn() => auth::user()?->tipe_akun === 'SU')
                            ->preload(), 
                            // Asumsi Anda sudah mengimplementasikan logika tipe_akun di model user
                    ])
                    ->columns(2),

                                Section::make('Data Pribadi')
                    ->schema([
                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir'),

                        Select::make('jenis_kelamin')
                            ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                            ->label('Jenis Kelamin'),

                        TextInput::make('no_telp')
                            ->label('Nomor Telepon')
                            ->tel(),

                        Textarea::make('alamat')
                            ->rows(2)
                            ->label('Alamat')
                            ->columnSpanFull(), // Agar Textarea mengambil 2 kolom jika di dalam columns(2)
                    ])
                    ->columns(2),

                    ]);
    }
}
