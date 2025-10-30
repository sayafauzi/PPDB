<?php

namespace App\Observers;

use App\Models\Registrasi;
use App\Notifications\RegistrasiDibuatNotification;
use App\Notifications\StatusRegistrasiUpdatedNotification;

class RegistrasiObserver
{
    public function created(Registrasi $registrasi): void
    {
        $orangTua = $registrasi->anak->orangTua;
        $orangTua->notify(new RegistrasiDibuatNotification($registrasi));
    }

    public function updated(Registrasi $registrasi): void
    {
        if ($registrasi->wasChanged('status')) {
            $orangTua = $registrasi->anak->orangTua;
            $orangTua->notify(new StatusRegistrasiUpdatedNotification($registrasi));
        }
    }
}
