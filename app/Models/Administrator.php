<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrator extends Authenticatable
{
    use HasFactory;
    const ROLE_FILING = 'FILING';
    const ROLE_CEK = 'CEK';
    const ROLE_KABID = 'KABID';
    const ROLE_KADIS = 'KADIS';

    protected $table = 'administrators';
    protected $fillable = [
        'name', 'jabatan', 'username', 'phone', 'password', 'is_active', 'avatar', 'role'
    ];

    public static function role()
    {
        return [
            'FILING' => self::ROLE_FILING,
            'CEK' => self::ROLE_CEK,
            'KABID' => self::ROLE_KABID,
            'KADIS' => self::ROLE_KADIS,
        ];
    }
}
