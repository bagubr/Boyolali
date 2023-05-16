<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_name', 'user_id', 'uuid', 'approval_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user_information()
    {
        return $this->belongsTo(UserInformation::class, 'uuid', 'uuid');
    }
}
