<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gsb extends Model
{
    use HasFactory;
    protected $fillable = [
        'jap',
        'jkp',
        'jks',
        'jlp',
        'jls',
        'jling',
    ];
}
