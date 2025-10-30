<?php

namespace App\Filament\Resources\Sekolah\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SekolahTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_sekolah')->sortable()->searchable(),
                TextColumn::make('nama_sekolah')->sortable()->searchable(),
                TextColumn::make('jenisSekolah.nama_jenis')
                    ->label('Jenis Sekolah')
                    ->sortable(),
                IconColumn::make('status_aktif')
                    ->boolean()
                    ->label('Aktif'),
                TextColumn::make('biaya_pendaftaran')
                    ->label('Biaya Pendaftaran')
                    ->money('IDR', true),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('jenis_sekolah_id')
                    ->label('Jenis Sekolah')
                    ->relationship('jenisSekolah', 'nama_jenis')
                    ->searchable(),
                TernaryFilter::make('status_aktif')
                    ->label('Aktif?'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
