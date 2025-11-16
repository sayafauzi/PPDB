<?php

namespace App\Observers;

use App\Models\JenisSekolah;
use App\Models\Registrasi;
use App\Notifications\RegistrasiDibuatNotification;
use App\Notifications\StatusRegistrasiUpdatedNotification;
use Illuminate\Support\Facades\DB;

class RegistrasiObserver
{
    public function created(Registrasi $registrasi)
    {
        $orangTua = $registrasi->anak->orangTua;
        $orangTua->notify(new RegistrasiDibuatNotification($registrasi));

        if (!$registrasi->jenis_sekolah_id) return;

        // DB::transaction(function () use ($registrasi) {
        //     $jenis = JenisSekolah::lockForUpdate()->find($registrasi->jenis_sekolah_id);

        //     if (!$jenis) return;

        //     if ($jenis->sisa_kuota > $jenis->kapasitas) {
        //         $jenis->sisa_kuota -= 1;
        //         $jenis->save();
        //     } else {
        //         throw new \Exception("Kuota penuh untuk jenis sekolah ini.");
        //     }
        // });

        DB::transaction(function () use ($registrasi) {
            $jenis = JenisSekolah::where('id', $registrasi->jenis_sekolah_id)
                ->lockForUpdate()
                ->first();

            if ($jenis && $jenis->sisa_kuota > 0) {
                $jenis->decrement('sisa_kuota');
            }
        });
    }

    public function deleting(Registrasi $registrasi)
    {
        if (!$registrasi->jenis_sekolah_id) return;

        DB::transaction(function () use ($registrasi) {
            $jenis = JenisSekolah::lockForUpdate()->find($registrasi->jenis_sekolah_id);

            if (!$jenis) return;

            if ($jenis->sisa_kuota < $jenis->kapasitas) {
                $jenis->sisa_kuota += 1;
                $jenis->save();
            }
        });
    }

    public function updated(Registrasi $registrasi): void
    {
        if ($registrasi->wasChanged('status')) {
            $orangTua = $registrasi->anak->orangTua;
            $orangTua->notify(new StatusRegistrasiUpdatedNotification($registrasi));
        }

        // Cek jika status berubah
        if (!$registrasi->isDirty('status')) {
            return;
        }

        $old = $registrasi->getOriginal('status');
        $new = $registrasi->status;

        // status yg mengembalikan kuota:
        $returnStatus = ['pendaftaran_batal', 'bukti_bayar_ditolak'];

        if (!in_array($new, $returnStatus)) {
            return;
        }

        DB::transaction(function () use ($registrasi) {
            $jenis = JenisSekolah::lockForUpdate()->find($registrasi->jenis_sekolah_id);

            if (!$jenis) return;

            if ($jenis->sisa_kuota < $jenis->kapasitas) {
                $jenis->increment('sisa_kuota');
            }
        });
    }


}
