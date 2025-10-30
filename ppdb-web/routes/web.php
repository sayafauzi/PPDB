<?php

use App\Filament\Admin\Pages\RegisterWithInvite;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/register', RegisterWithInvite::class)->name('filament.admin.pages.register');
