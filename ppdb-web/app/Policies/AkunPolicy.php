<?php

namespace App\Policies;

use App\Models\Akun;

class AkunPolicy
{
    public function viewAny(Akun $user): bool
    {
        // Hanya SuperAdmin dan Admin dapat melihat daftar akun
        return in_array($user->tipe_akun, ['SU', 'A']);
    }

    public function view(Akun $user, Akun $target): bool
    {
        if ($user->tipe_akun === 'SU') {
            return true;
        }

        // Admin hanya bisa melihat akun di sekolah yang ia kelola
        if ($user->tipe_akun === 'A') {
            return $target->tipe_akun !== 'SU';
        }

        // Orang tua hanya bisa melihat akunnya sendiri
        return $user->id === $target->id;
    }

    public function create(Akun $user): bool
    {
        // SuperAdmin bisa buat semua akun; Admin hanya bisa buat akun orang tua
        return in_array($user->tipe_akun, ['SU', 'A']);
    }

    public function update(Akun $user, Akun $target): bool
    {
        if ($user->tipe_akun === 'SU') {
            return true;
        }

        if ($user->tipe_akun === 'A') {
            return $target->tipe_akun !== 'SU';
        }

        return $user->id === $target->id;
    }

    public function delete(Akun $user, Akun $target): bool
    {
        return $user->tipe_akun === 'SU';
    }

    public function restore(Akun $user, Akun $target): bool
    {
        return $user->tipe_akun === 'SU';
    }

    public function forceDelete(Akun $user, Akun $target): bool
    {
        return $user->tipe_akun === 'SU';
    }
}
