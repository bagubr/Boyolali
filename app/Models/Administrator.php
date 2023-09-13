<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrator extends Authenticatable
{
    use HasFactory;
    const ROLE_FILING = 'FILING';
    const ROLE_SUBKOR = 'SUBKOR';
    const ROLE_KABID = 'KABID';
    const ROLE_KADIS = 'KADIS';
    const ROLE_ADMIN = 'ADMIN';

    protected $table = 'administrators';
    protected $fillable = [
        'name', 'jabatan', 'username', 'phone', 'password', 'is_active', 'avatar', 'role'
    ];

    public static function role()
    {
        return [
            self::ROLE_FILING => 'Petugas Agenda',
            self::ROLE_SUBKOR => 'Subkor Pengendalian dan Pemanfaatan Tata Ruang',
            self::ROLE_KABID => 'Kabid Tata Ruang',
            self::ROLE_KADIS => 'Ka. DPUPR',
            self::ROLE_ADMIN => 'Administrator',
        ];
    }
}
