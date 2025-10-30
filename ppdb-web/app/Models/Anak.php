<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    use HasFactory;

    protected $table = 'anak';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'id','id_akun_orangtua','nama_lengkap','tempat_lahir','tanggal_lahir',
        'asal_sekolah','rerata_rapor','prestasi','jenis_kelamin','agama',
        'kewarganegaraan','nik','no_kk','no_akta_lahir','tempat_tinggal',
        'moda_transportasi','jarak_rumah','anak_ke'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun_orangtua');
    }

    public function orangtua()
    {
        return $this->belongsTo(Akun::class, 'id_akun_orangtua');
    }

    public function registrasi()
    {
        return $this->hasMany(Registrasi::class, 'id_anak');
    }
}
