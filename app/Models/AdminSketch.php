<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminSketch extends Authenticatable
{
    use HasFactory;
    protected $table = 'admin_sketchs';
    protected $fillable = [
        'name', 'username', 'phone', 'password', 'is_active', 'avatar'
    ];
}
