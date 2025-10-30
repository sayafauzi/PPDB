<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\LoginResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomLoginResponse extends LoginResponse
{
    public function toResponse($request): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return parent::toResponse($request);
        }

        // Redirect berdasarkan tipe_akun
        switch ($user->tipe_akun) {
            case 'SU':
            case 'A':
                return new RedirectResponse(route('filament.admin.pages.dashboard'));

            case 'U':
                return new RedirectResponse(route('filament.parent.pages.dashboard'));

            default:
                return redirect()->to('/login');
        }
    }     
}