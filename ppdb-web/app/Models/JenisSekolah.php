<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSekolah extends Model
{
    use HasFactory;

    protected $table = 'jenis_sekolah';

    protected $fillable = [
        'kode_jenis', 'nama_jenis', 'kuota', 'sisa_kuota', 'kapasitas', 'status_aktif'
    ];

    // public function sekolah()
    // {
    //     return $this->hasMany(Sekolah::class, 'jenis_sekolah_id');
    // }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }
    
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }
}
