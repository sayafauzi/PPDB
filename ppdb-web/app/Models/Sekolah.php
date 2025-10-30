<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sekolah';
    protected $guarded = [];
    protected $fillable = [
        'kode_sekolah','nama_sekolah','type','alamat','kontak','nama_rekening',
        'no_rekening','syarat','link_grup','biaya_pendaftaran','biaya_awal',
        'biaya_spp','status_aktif','jenis_sekolah_id'
    ];

    public function jenisSekolah()
    {
        return $this->belongsTo(JenisSekolah::class);
    }

    public function akunSekolah()
    {
        return $this->hasMany(AkunSekolah::class, 'sekolah_id');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }

    public function admins()
    {
        return $this->belongsToMany(Akun::class, 'akun_sekolah')
                    ->withPivot('role_in_school')
                    ->withTimestamps();
    }

    public function registrasi()
    {
        return $this->hasMany(Registrasi::class, 'id_sekolah');
    }
}
