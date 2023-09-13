<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KbliActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'content'
    ];
}
