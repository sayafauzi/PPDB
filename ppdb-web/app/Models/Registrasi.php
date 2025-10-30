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
}
