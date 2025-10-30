<?php

namespace App\Policies;

use App\Models\Akun;
use App\Models\InviteCode;

class InviteCodePolicy
{
    public function viewAny(Akun $user): bool
    {
        return in_array($user->tipe_akun, ['SU', 'A']);
    }

    public function create(Akun $user): bool
    {
        return in_array($user->tipe_akun, ['SU', 'A']);
    }

    public function update(Akun $user, InviteCode $inviteCode): bool
    {
        return $user->tipe_akun === 'SU';
    }

    public function delete(Akun $user, InviteCode $inviteCode): bool
    {
        return $user->tipe_akun === 'SU';
    }
}
