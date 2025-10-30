<?php

namespace App\Filament\Parent\Pages;

use App\Filament\Parent\Widgets\ParentStats;
use Filament\Pages\Page;
use App\Models\Anak;
use App\Models\Registrasi;
use BackedEnum;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Dashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
    protected string $view = 'filament.parent.pages.dashboard';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard Orang Tua';
    protected static ?string $slug = 'dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public function getHeaderWidgets(): array
    {
        return [
            ParentStats::class,
            // AnakRegistrasiChart::class,
        ];
    }
}

// class ParentStats extends StatsOverviewWidget
// {
//     
// }

class AnakRegistrasiChart extends ChartWidget
{
    protected ?string $heading = 'Status Registrasi Anak';
    protected string $color = 'info';

    protected function getData(): array
    {
        $akunId = Auth::id();

        $data = Registrasi::whereHas('anak', function ($q) use ($akunId) {
                $q->where('akun_id', $akunId);
            })
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Registrasi',
                    'data' => array_values($data),
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
