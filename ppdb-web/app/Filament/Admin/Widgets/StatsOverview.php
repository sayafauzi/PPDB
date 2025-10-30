<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Registrasi;
use App\Models\Anak;
use App\Models\Sekolah;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pendaftar', Registrasi::count())
                ->description('Jumlah total pendaftar di sistem PPDB')
                ->icon('heroicon-o-user-group'),

            Stat::make('Total Anak', Anak::count())
                ->description('Jumlah data anak terdaftar')
                ->icon('heroicon-o-academic-cap'),

            Stat::make('Sekolah Aktif', Sekolah::where('status_aktif', true)->count())
                ->description('Jumlah sekolah yang aktif menerima siswa')
                ->icon('heroicon-o-building-office'),
        ];
    }
}
