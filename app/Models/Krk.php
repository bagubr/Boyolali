<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krk extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'kbg',
        'kdb',
        'klb',
        'kdh',
        'psu',
        'jaringan_utilitas',
        'prasarana_jalan',
        'sungai_bertanggul',
        'sungai_tidak_bertanggul',
        'mata_air',
        'waduk',
        'tol',
        'ktb',
        'building_function_id',
    ];

    public function building_function()
    {
        return $this->belongsTo(BuildingFunction::class);
    }

    public function gsb()
    {
        return $this->hasOne(Gsb::class);
    }

    public function additional_information()
    {
        return $this->hasMany(AdditionalInformation::class);
    }

    public function other_technical_information()
    {
        return $this->hasOne(OtherTechnicalInformation::class);
    }
}
