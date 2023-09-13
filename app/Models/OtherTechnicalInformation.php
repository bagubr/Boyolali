<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherTechnicalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'krk_id',
        'srp',
        'kkop',
    ];

    public function krk()
    {
        return $this->belongsTo(Krk::class);
    }
}
