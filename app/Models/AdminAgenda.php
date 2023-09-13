<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminAgenda extends Authenticatable
{
    use HasFactory;
    protected $table = 'admin_agenda';
    protected $fillable = [
        'name', 'username', 'phone', 'password', 'is_active', 'avatar'
    ];
}
