<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantReference extends Model
{
    use HasFactory;
    const STATUS_PROSES = 'PROSES';
    const STATUS_APPROVE = 'APPROVE';
    const STATUS_DECLINE = 'DECLINE';
    protected $fillable = [
        'user_information_id', 'reference_type_id', 'file', 'status', 'is_upload'
    ];

    public function user_information()
    {
        return $this->belongsTo(UserInformation::class);
    }

    public function reference_type()
    {
        return $this->belongsTo(ReferenceType::class);
    }
}
