<?php

namespace App\Policies;

use App\Models\Akun;
use App\Models\JenisSekolah;

class JenisSekolahPolicy
{
    public function viewAny(Akun $user): bool
    {
        return in_array($user->tipe_akun, ['SU', 'A']);
    }

    public function view(Akun $user, JenisSekolah $jenisSekolah): bool
    {
        return in_array($user->tipe_akun, ['SU', 'A']);
    }

    public function create(Akun $user): bool
    {
        return $user->tipe_akun === 'SU';
    }

    public function update(Akun $user, JenisSekolah $jenisSekolah): bool
    {
        return $user->tipe_akun === 'SU';
    }

    public function delete(Akun $user, JenisSekolah $jenisSekolah): bool
    {
        return $user->tipe_akun === 'SU';
    }

    public function restore(Akun $user, JenisSekolah $jenisSekolah): bool
    {
        return $user->tipe_akun === 'SU';
    }

    public function forceDelete(Akun $user, JenisSekolah $jenisSekolah): bool
    {
        return $user->tipe_akun === 'SU';
    }
}
