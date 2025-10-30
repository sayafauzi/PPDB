<?php

namespace App\Filament\Parent\Resources\Anak\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AnakTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_lengkap')->searchable(),
                TextColumn::make('orangTua.name')->label('Orang Tua'),
                TextColumn::make('tanggal_lahir')->date(),
                BadgeColumn::make('jenis_kelamin'),
                TextColumn::make('nik')->toggleable(),
                TextColumn::make('asal_sekolah')->toggleable(),
            ])
            ->filters([
                SelectFilter::make('jenis_kelamin')->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ]),
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
