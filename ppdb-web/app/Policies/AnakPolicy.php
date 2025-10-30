<?php

namespace App\Policies;

use App\Models\Akun;
use App\Models\Anak;

class AnakPolicy
{
    public function viewAny(Akun $user): bool
    {
        return in_array($user->tipe_akun, ['U','A', 'SU']);
    }

    public function view(Akun $user, Anak $anak): bool
    {
        return $user->tipe_akun === 'SU' || $anak->id_akun_orangtua === $user->id;
    }

    public function create(Akun $user): bool
    {
        return $user->tipe_akun === 'U' || $user->tipe_akun === 'SU';
    }

    public function update(Akun $user, Anak $anak): bool
    {
        return $user->tipe_akun === 'SU' || $anak->id_akun_orangtua === $user->id;
    }

    public function delete(Akun $user, Anak $anak): bool
    {
        return $user->tipe_akun === 'SU';
    }
}
