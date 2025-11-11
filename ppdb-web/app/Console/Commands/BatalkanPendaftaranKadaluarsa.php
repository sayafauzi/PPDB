<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Registrasi;
use Illuminate\Support\Carbon;

class BatalkanPendaftaranKadaluarsa extends Command
{
    protected $signature = 'registrasi:cek-deadline';
    protected $description = 'Batalkan pendaftaran yang melewati deadline pembayaran';

    public function handle()
    {
        $now = Carbon::now();

        $kadaluarsa = Registrasi::where('status', 'menunggu_pembayaran')
            ->where('deadline_bayar', '<', $now)
            ->get();

        foreach ($kadaluarsa as $r) {
            $r->update(['status' => 'pendaftaran_batal']);
            $this->info("Pendaftaran {$r->id} otomatis dibatalkan (deadline terlewati).");
        }

        return Command::SUCCESS;
    }
}
