<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InviteCode extends Model
{
    use HasFactory;

    protected $table = 'invite_codes';

    protected $fillable = [
        'code',
        'target_tipe',
        'expired_at',
        'is_used',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    // 🧠 Auto generate code unik
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->code)) {
                $model->code = self::generateCode();
            }
        });
    }

    public static function generateCode()
    {
        return strtoupper(Str::random(10));
    }

    // Relasi opsional jika ingin tahu siapa pembuatnya
    public function creator()
    {
        return $this->belongsTo(Akun::class, 'created_by');
    }
}
