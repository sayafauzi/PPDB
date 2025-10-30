<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Filament::serving(function () {
        //     $user = Filament::auth()->user();
        //     if (!$user) {
        //         return;
        //     }

        //     // Register custom navigation items per role
        //     $navItems = [];

        //     if ($user->tipe_akun === 'SU') {
        //         $navItems = [
        //             NavigationItem::make('Dashboard')
        //                 ->url(route('filament.admin.pages.dashboard'))
        //                 ->icon('heroicon-o-home'),
        //         ];
        //     }

        //     if ($user->tipe_akun === 'A') {
        //         $navItems = [
        //             NavigationItem::make('Dashboard')
        //                 ->url(route('filament.admin.pages.dashboard'))
        //                 ->icon('heroicon-o-home'),
        //         ];
        //     }

        //     if ($user->tipe_akun === 'U') {
        //         $navItems = [
        //             NavigationItem::make('Dashboard')
        //                 ->url(route('filament.admin.pages.dashboard'))
        //                 ->icon('heroicon-o-home'),
        //         ];
        //     }

        //     // Daftarkan item navigasi hasil filter
        //     Filament::registerNavigationItems($navItems);

        // });
    }
}
