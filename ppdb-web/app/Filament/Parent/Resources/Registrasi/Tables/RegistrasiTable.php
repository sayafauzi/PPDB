<?php

namespace App\Filament\Parent\Resources\Registrasi\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class RegistrasiTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('anak.nama_lengkap')->label('Nama Anak'),
                TextColumn::make('sekolah.nama_sekolah')->label('Sekolah'),
                BadgeColumn::make('status')
                ->colors([
                    'gray' => 'menunggu_pembayaran',
                    'warning' => 'menunggu_konfirmasi',
                    'success' => 'dibayar',
                    'info' => 'lulus_tes_akademik',
                    'primary' => 'lulus',
                    'danger' => 'belum_diterima',
                ]),
                TextColumn::make('nominal_transfer')->money('IDR')->label('Nominal'),
                TextColumn::make('waktu_daftar')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
