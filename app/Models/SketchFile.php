<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SketchFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'file', 'user_information_id'
    ];

    public function user_information()
    {
        return $this->belongsTo(UserInformation::class);
    }
}
