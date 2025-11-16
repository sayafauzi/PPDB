<?php

namespace App\Filament\Resources\Registrasi\Pages;

use App\Exports\RegistrasiAnakExport;
use App\Filament\Resources\Registrasi\RegistrasiResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListRegistrasi extends ListRecords
{
    protected static string $resource = RegistrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Buat Registrasi'),
            Action::make('export_registrasi')
                ->label('Export Registrasi Anak')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    return Excel::download(new RegistrasiAnakExport, 'registrasi-anak.xlsx');
                }),
        ];
    }
}
