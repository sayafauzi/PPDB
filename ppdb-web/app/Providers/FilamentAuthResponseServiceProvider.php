<?php

namespace App\Providers;

use Filament\Auth\Http\Responses\LoginResponse;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class FilamentAuthResponseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app()->bind(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $user = Auth::user();

                    if ($user->tipe_akun === 'SU' || $user->tipe_akun === 'A') {
                        return redirect()->intended(route('filament.admin.pages.dashboard'));
                    }

                    if ($user->tipe_akun === 'U') {
                        return redirect()->intended(route('filament.parent.pages.dashboard'));
                    }

                    Auth::logout();
                    abort(403, 'Akses tidak diizinkan.');
                }
            };
        });
    }
}
