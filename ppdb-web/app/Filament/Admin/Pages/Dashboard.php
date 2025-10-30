<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\RegistrasiChart as WidgetsRegistrasiChart;
use Filament\Pages\Page;
use App\Models\Sekolah;
use App\Models\Anak;
use App\Models\Registrasi;
use BackedEnum;
use Filament\Notifications\Livewire\Notifications;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use RegistrasiChart;

class Dashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';
    protected string $view = 'filament.admin.pages.dashboard';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard Admin';
    protected static ?string $slug = 'dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationLabel(): string
    {
        return 'Dashboard Admin';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Admin\Widgets\StatsOverview::class
        ];
    }
    public static function getWidgets(): array
    {
        return [
            AccountWidget::class,
            Notifications::class,
            WidgetsRegistrasiChart::class
            // tambahkan widget statistik pendaftar bila sudah
        ];
    }

}


