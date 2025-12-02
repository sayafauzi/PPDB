<?php

namespace App\Providers;

use App\Http\Responses\CustomLoginResponse;
use Illuminate\Support\ServiceProvider;
use App\Models\Registrasi;
use App\Observers\RegistrasiObserver;
use Filament\Facades\Filament;
use Filament\Auth\Http\Responses\LoginResponse as BaseLoginResponse;
use Filament\Forms\Components\DateTimePicker;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
                app()->bind(BaseLoginResponse::class, CustomLoginResponse::class);
            });
            Registrasi::observe(RegistrasiObserver::class);

            DateTimePicker::configureUsing(function (DateTimePicker $component): void {
            $component->timezone('Asia/Jakarta');
        });
        
    }
}
