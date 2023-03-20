<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSketch extends Model
{
    use HasFactory;
    protected $table = 'admin_sketchs';
    protected $fillable = [
        'name', 'username', 'phone', 'password', 'is_active', 'avatar'
    ];
}
