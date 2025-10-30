<?php

namespace App\Policies;

use App\Models\Akun;
use App\Models\AkunSekolah;

class AkunSekolahPolicy
{
    public function viewAny(Akun $user): bool
    {
        return in_array($user->tipe_akun, ['SU', 'A']);
    }

    public function view(Akun $user, AkunSekolah $relasi): bool
    {
        return $user->tipe_akun === 'SU';
    }

    public function create(Akun $user): bool
    {
        return $user->tipe_akun === 'SU';
    }

    public function update(Akun $user, AkunSekolah $relasi): bool
    {
        return $user->tipe_akun === 'SU';
    }

    public function delete(Akun $user, AkunSekolah $relasi): bool
    {
        return $user->tipe_akun === 'SU';
    }
}
