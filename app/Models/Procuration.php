<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procuration extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'phone', 'address', 'user_information_id'
    ];
}
