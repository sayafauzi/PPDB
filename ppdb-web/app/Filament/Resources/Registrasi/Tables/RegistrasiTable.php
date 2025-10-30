<?php

namespace App\Filament\Resources\Registrasi\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

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
                SelectFilter::make('status')->options([
                    'menunggu_pembayaran' => 'Menunggu Pembayaran',
                    'dibayar' => 'Dibayar',
                    'lulus' => 'Lulus',
                ]),
            ])
            ->recordActions([
                Action::make('whatsapp')
                ->label('Kirim WA')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->color('success')
                ->url(fn ($record) => 
                    "https://wa.me/" . preg_replace('/[^0-9]/', '', $record->anak->akun->no_telp) .
                    "?text=" . urlencode("Halo, ini Admin PPDB. Kami ingin menginformasikan status pendaftaran anak Anda: {$record->status}.")
                )
                ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
