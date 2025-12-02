<?php

namespace App\Filament\Parent\Pages\Auth;

use App\Models\Akun;
use Filament\Actions\Action;
use Filament\Auth\Pages\Register;
use Filament\Forms;
use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class CustomRegister extends Register
{
    protected string $view = 'filament.parent.pages.custom-register';

    public function form(Schema $getForms): Schema
    {
        return $getForms
            ->schema([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique('akun', 'email')
                    ->required(),

                TextInput::make('no_telp')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->required(),

                Grid::make(2)
                    ->schema([
                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required(),

                        Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),
                    ]),

                Textarea::make('alamat')
                        ->label('Alamat')
                        ->required(),

                Grid::make(2)
                    ->schema([
                        TextInput::make('kelurahan')
                            ->required(),

                        TextInput::make('kecamatan')
                            ->required(),
                    ]),

                // Hidden default tipe akun
                Hidden::make('tipe_akun')
                    ->default('U'),

                TextInput::make('password')
                    ->password()
                    ->label('Password')
                    ->required()
                    ->minLength(6),

                TextInput::make('password_confirmation')
                    ->password()
                    ->label('Konfirmasi Password')
                    ->same('password')
                    ->required(),

                Action::make('register')
                    ->label('Daftar')
                    ->button()
                    ->submit('register')
                    ->color('primary')
                    ->icon('heroicon-o-user-plus'),
            ])
            ->statePath('data');
    }

    protected function handleRegistration(array $data): Akun
    {
        // Enkripsi password
        $data['password'] = Hash::make($data['password']);

        // tipe_akun tetap dipaksa U
        $data['tipe_akun'] = 'U';

        return Akun::create($data);
    }
}
