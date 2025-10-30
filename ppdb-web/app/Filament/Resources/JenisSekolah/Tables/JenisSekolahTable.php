<?php

namespace App\Filament\Resources\JenisSekolah\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class JenisSekolahTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_jenis')->sortable()->searchable(),
                TextColumn::make('nama_jenis')->sortable()->searchable(),
                TextColumn::make('kuota')->label('Kuota')->numeric(),
                TextColumn::make('sisa_kuota')->label('Sisa')->numeric(),
                TextColumn::make('kapasitas')->numeric(),
                IconColumn::make('status_aktif')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('akun.name')
                    ->label('Admin Pembuat'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
