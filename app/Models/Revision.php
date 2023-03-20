<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    use HasFactory;
    protected $table = 'revisions';
    protected $fillable = [
        'from', 'to', 'from_name', 'to_name', 'note', 'user_information_id'
    ];

    public function user_information()
    {
        return $this->belongsTo(UserInformation::class);
    }
}
