<?php

use App\Filament\Admin\Pages\RegisterWithInvite;
use App\Http\Controllers\Auth\CustomRegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/register', RegisterWithInvite::class)->name('filament.admin.pages.register');

// Route::get('/parent/register', [CustomRegisterController::class, 'show'])
//     ->name('parent.register');

// Route::post('/parent/register', [CustomRegisterController::class, 'store'])
//     ->name('parent.register.submit');

