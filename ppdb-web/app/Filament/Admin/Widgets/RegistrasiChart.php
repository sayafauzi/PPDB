<?php

namespace App\Filament\Admin\Widgets;

// use Filament\Widgets\Widget;

// class RegistrasiChart extends Widget
// {
//     protected string $view = 'filament.admin.widgets.registrasi-chart';
// }


use App\Models\Registrasi;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RegistrasiChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Pendaftar';
    protected ?string $description = 'Jumlah pendaftar berdasarkan status registrasi';
    protected string $view = 'filament.admin.widgets.registrasi-chart';

    protected function getData(): array
    {
        // Ambil data jumlah registrasi per status
        $data = Registrasi::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pendaftar',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#3b82f6',
                        '#22c55e',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6',
                        '#14b8a6',
                        '#f97316',
                        '#eab308',
                        '#10b981',
                        '#6366f1',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        // bisa 'bar', 'pie', 'doughnut', 'line'
        return 'bar';
    }
}

