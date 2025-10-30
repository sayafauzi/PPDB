<?php

namespace App\Filament\Parent\Widgets;

use App\Models\Anak;
use App\Models\Registrasi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ParentStats extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        // Hitung data untuk user dengan tipe_akun = 'U'
        $totalAnak = Anak::where('id_akun_orangtua', $user->id)->count();

        $totalRegistrasi = Registrasi::whereHas('anak', function ($q) use ($user) {
            $q->where('id_akun_orangtua', $user->id);
        })->count();

        $registrasiLulus = Registrasi::whereHas('anak', function ($q) use ($user) {
            $q->where('id_akun_orangtua', $user->id);
        })->where('status', 'lulus')->count();

        return [
            Stat::make('Jumlah Anak', $totalAnak)
                ->description('Total anak terdaftar')
                ->color('info')
                ->icon('heroicon-o-users'),

            Stat::make('Total Registrasi', $totalRegistrasi)
                ->description('Jumlah seluruh pendaftaran')
                ->color('warning')
                ->icon('heroicon-o-clipboard-document'),

            Stat::make('Diterima', $registrasiLulus)
                ->description('Anak yang sudah lulus seleksi')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
