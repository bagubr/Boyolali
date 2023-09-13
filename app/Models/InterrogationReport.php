<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterrogationReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_information_id','building_condition','street_name','allocation','note','employee'
    ];

    public function user_information()
    {
        return $this->belongsTo(UserInformation::class);
    }
}
