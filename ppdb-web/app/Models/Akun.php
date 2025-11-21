<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Akun extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $table = 'akun';

    protected $fillable = [
        'email','password','tipe_akun','no_telp','name','tanggal_lahir',
        'jenis_kelamin','alamat','kelurahan','kecamatan','id_sekolah'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    // public function sekolah()
    // {
    //     return $this->belongsTo(Sekolah::class, 'id_sekolah');
    // }

    public function sekolah()
    {
        return $this->belongsToMany(Sekolah::class, 'akun_sekolah', 'akun_id', 'sekolah_id')
            ->withPivot('role_in_school')
            ->withTimestamps();
    }


    public function jenisSekolah()
    {
        return $this->hasMany(JenisSekolah::class, 'akun_id');
    }

    public function sekolahAssigns()
    {
        return $this->belongsToMany(Sekolah::class, 'akun_sekolah')
                    ->withPivot('role_in_school')
                    ->withTimestamps();
    }

    public function anak()
    {
        return $this->hasMany(Anak::class, 'id_akun_orangtua');
    }

    public function registrasi()
    {
        return $this->hasMany(Registrasi::class, 'id_akun');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'superadmin') {
            // Hanya izinkan jika tipe_akun adalah 'SU'
            return $this->tipe_akun === 'SU'; 
        }

        // 2. Logika untuk Panel Admin Lain/Default (Misal: 'admin')
        // Asumsi panel lain (selain 'superadmin') boleh diakses oleh 'A' dan 'SU'.
        if ($panel->getId() === 'admin') {
            return in_array($this->tipe_akun, ['A', 'SU']);
        }

        if ($panel->getId() === 'parent') {
            // Hanya Orang Tua (U)
            return $this->tipe_akun === 'U';
        }

        return true;
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = self::generateCustomId($model->tipe_akun);
            }
        });
    }

    public static function generateCustomId($prefix = null): string
    {
        // Jika prefix tidak valid, fallback ke default (U)
        if (!in_array($prefix, ['SU', 'A', 'U'])) {
            $prefix = 'U';
        }

        $datePart = now()->format('Ymd');
        $randPart = strtoupper(Str::random(6));

        return "{$prefix}{$datePart}{$randPart}";
    }
}
