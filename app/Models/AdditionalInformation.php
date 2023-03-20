<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'krk_id'
    ];

    public function krk()
    {
        return $this->belongsTo(Krk::class);
    }
}
