<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    use HasFactory;

    protected $table = 'registrasi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id','id_anak','id_sekolah','status','bukti_pembayaran',
        'waktu_daftar','deadline_bayar','nominal_transfer','kode_transaksi'
    ];

    protected $casts = [
        'waktu_daftar' => 'datetime',
        'deadline_bayar' => 'datetime',
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'id_anak');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }

    public function jenisSekolah()
    {
        return $this->belongsTo(JenisSekolah::class, 'jenis_sekolah_id');
    }
    
    // 🔥 KUOTA OTOMATIS
    protected static function booted()
    {
        static::creating(function ($registrasi) {
            if ($registrasi->jenis_sekolah_id) {
                $jenis = $registrasi->jenisSekolah()->lockForUpdate()->first();
                if ($jenis && $jenis->sisa_kuota > 0) {
                    $jenis->decrement('sisa_kuota');
                }
            }
        });

        static::deleting(function ($registrasi) {
            if ($registrasi->jenis_sekolah_id) {
                $jenis = $registrasi->jenisSekolah()->lockForUpdate()->first();
                if ($jenis) {
                    $jenis->increment('sisa_kuota');
                }
            }
        });

        static::updating(function ($registrasi) {
            // Jika status berubah menjadi batal, tambah kuota kembali
            if ($registrasi->isDirty('status')) {
                $oldStatus = $registrasi->getOriginal('status');
                $newStatus = $registrasi->status;

                if (
                    $oldStatus !== 'pendaftaran_batal' &&
                    in_array($newStatus, ['pendaftaran_batal', 'bukti_bayar_ditolak'])
                ) {
                    $jenis = $registrasi->jenisSekolah()->lockForUpdate()->first();
                    if ($jenis) {
                        $jenis->increment('sisa_kuota');
                    }
                }
            }
        });
    }

}
