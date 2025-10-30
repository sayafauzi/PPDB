<?php

namespace App\Filament\Resources\InviteCodes\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InviteCodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Kode Undangan')
                    ->disabled()
                    ->default(fn() => strtoupper(\Illuminate\Support\Str::random(10)))
                    ->dehydrated(),
                Select::make('target_tipe')
                    ->label('Tipe Akun Target')
                    ->options([
                        'A' => 'Admin Sekolah',
                    ])
                    ->default('A')
                    ->required(),
                DateTimePicker::make('expired_at')
                    ->label('Berlaku Sampai')
                    ->default(now()->addDays(7))
                    ->required(),
                Toggle::make('is_used')
                    ->label('Sudah Digunakan')
                    ->disabled(),
            ]);
    }
}
