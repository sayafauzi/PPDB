<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    protected $policies = [
        \App\Models\JenisSekolah::class => \App\Policies\JenisSekolahPolicy::class,
        \App\Models\Sekolah::class => \App\Policies\SekolahPolicy::class,
        \App\Models\Anak::class => \App\Policies\AnakPolicy::class,
        \App\Models\Akun::class => \App\Policies\AkunPolicy::class,
        \App\Models\AkunSekolah::class => \App\Policies\AkunSekolahPolicy::class,
        \App\Models\Registrasi::class => \App\Policies\RegistrasiPolicy::class,
        

        // Tambahkan policy lain nanti, seperti:
        // Sekolah::class => SekolahPolicy::class,
        // Registrasi::class => RegistrasiPolicy::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Contoh Gate manual tambahan (opsional)
        Gate::define('isSuperAdmin', function ($user) {
            return $user->tipe_akun === 'SU';
        });
    }
}
