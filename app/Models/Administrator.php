<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrator extends Authenticatable
{
    use HasFactory;
    const ROLE_AGENDA = 'AGENDA';
    const ROLE_GAMBAR = 'GAMBAR';
    const ROLE_KABID = 'KABID';
    const ROLE_KADIS = 'KADIS';

    protected $table = 'administrators';
    protected $fillable = [
        'name', 'username', 'phone', 'password', 'is_active', 'avatar', 'role'
    ];

    public static function role()
    {
        return [
            'AGENDA' => self::ROLE_AGENDA,
            'GAMBAR' => self::ROLE_GAMBAR,
            'KABID' => self::ROLE_KABID,
            'KADIS' => self::ROLE_KADIS,
        ];
    }
}
