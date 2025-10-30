<?php

namespace App\Policies;

use App\Models\Akun;
use App\Models\Registrasi;

class RegistrasiPolicy
{
    /**
     * Determine whether the user can view any registrasi records.
     */
    public function viewAny(Akun $user): bool
    {
        // SuperAdmin & Admin bisa melihat semua pendaftar (di sekolah mereka)
        // Orang tua hanya bisa melihat registrasi anak mereka
        return in_array($user->tipe_akun, ['SU', 'A', 'U']);
    }

    /**
     * Determine whether the user can view the registrasi.
     */
    public function view(Akun $user, Registrasi $registrasi): bool
    {
        if ($user->tipe_akun === 'SU') {
            return true;
        }

        if ($user->tipe_akun === 'A') {
            // Admin hanya dapat melihat registrasi di sekolah yang diassign
            return $user->assignedSekolah()
                        ->where('sekolah_id', $registrasi->id_sekolah)
                        ->exists();
        }

        if ($user->tipe_akun === 'U') {
            // Orang tua hanya bisa melihat pendaftaran anak mereka sendiri
            return $registrasi->anak->id_akun_orangtua === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create a new registrasi.
     */
    public function create(Akun $user): bool
    {
        return in_array($user->tipe_akun, ['SU', 'U']);
    }

    /**
     * Determine whether the user can update the registrasi.
     */
    public function update(Akun $user, Registrasi $registrasi): bool
    {
        if ($user->tipe_akun === 'SU') {
            return true;
        }

        if ($user->tipe_akun === 'A') {
            // Admin bisa update status registrasi di sekolahnya
            return $user->assignedSekolah()
                        ->where('sekolah_id', $registrasi->id_sekolah)
                        ->exists();
        }

        if ($user->tipe_akun === 'U') {
            // Orang tua bisa update bukti bayar selama status masih menunggu
            return $registrasi->anak->id_akun_orangtua === $user->id
                && in_array($registrasi->status, [
                    'menunggu_pembayaran',
                    'bukti_bayar_ditolak',
                ]);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the registrasi.
     */
    public function delete(Akun $user, Registrasi $registrasi): bool
    {
        if ($user->tipe_akun === 'SU') {
            return true;
        }

        if ($user->tipe_akun === 'U') {
            // Orang tua hanya bisa membatalkan sebelum pembayaran
            return $registrasi->anak->id_akun_orangtua === $user->id &&
                   $registrasi->status === 'menunggu_pembayaran';
        }

        return false;
    }

    /**
     * Determine whether the user can restore a registrasi.
     */
    public function restore(Akun $user, Registrasi $registrasi): bool
    {
        return $user->tipe_akun === 'SU';
    }

    /**
     * Determine whether the user can permanently delete the registrasi.
     */
    public function forceDelete(Akun $user, Registrasi $registrasi): bool
    {
        return $user->tipe_akun === 'SU';
    }
}
