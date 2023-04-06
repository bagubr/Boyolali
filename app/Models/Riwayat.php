<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;
    protected $table = 'riwayat';
    protected $fillable = [
        'from', 'to', 'from_id', 'to_id', 'note', 'user_information_id'
    ];

    public function user_information()
    {
        return $this->belongsTo(UserInformation::class);
    }

    public function dari()
    {
        return $this->belongsTo(Administrator::class, 'from_id');
    }

    public function ke()
    {
        return $this->belongsTo(Administrator::class, 'to_id');
    }
}
