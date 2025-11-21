<?php

namespace App\Policies;

use App\Models\Akun;
use App\Models\Sekolah;

class SekolahPolicy
{
    /**
     * Determine whether the user can view any sekolah data.
     */
    public function viewAny(Akun $user): bool
    {
        // SuperAdmin & Admin dapat melihat semua sekolah yang diassign
        return in_array($user->tipe_akun, ['SU', 'A']);
    }

    /**
     * Determine whether the user can view a specific sekolah.
     */
    public function view(Akun $user, Sekolah $sekolah): bool
    {
        if ($user->tipe_akun === 'SU') {
            return true;
        }

        if ($user->tipe_akun === 'A') {
            // Admin hanya bisa melihat sekolah yang diassign
            return $user->sekolahAssigns()
                        ->where('sekolah_id', $sekolah->id)
                        ->exists();
        }

        // Orang tua tidak punya akses melihat sekolah di panel
        return false;
    }

    /**
     * Determine whether the user can create sekolah.
     */
    public function create(Akun $user): bool
    {
        // Hanya SuperAdmin yang dapat membuat sekolah baru
        return $user->tipe_akun === 'SU';
    }

    /**
     * Determine whether the user can update sekolah.
     */
    public function update(Akun $user, Sekolah $sekolah): bool
    {
        if ($user->tipe_akun === 'SU') {
            return true;
        }

        if ($user->tipe_akun === 'A') {
            // Admin hanya dapat memperbarui sekolah yang diassign
            return $user->sekolahAssigns()
                        ->where('sekolah_id', $sekolah->id)
                        ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can delete sekolah.
     */
    public function delete(Akun $user, Sekolah $sekolah): bool
    {
        // Hanya SuperAdmin yang berhak menghapus data sekolah
        return $user->tipe_akun === 'SU';
    }

    /**
     * Determine whether the user can restore sekolah.
     */
    public function restore(Akun $user, Sekolah $sekolah): bool
    {
        return $user->tipe_akun === 'SU';
    }

    /**
     * Determine whether the user can permanently delete sekolah.
     */
    public function forceDelete(Akun $user, Sekolah $sekolah): bool
    {
        return $user->tipe_akun === 'SU';
    }
}
