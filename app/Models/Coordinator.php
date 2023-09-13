<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    use HasFactory;
    protected $fillable = [
        'coordinator_admin_survei_id', 'admin_survei_id'
    ];

    public function admin_survei()
    {
        return $this->belongsTo(AdminSurvei::class);
    }

    public function coordinator_admin_survei()
    {
        return $this->belongsTo(AdminSurvei::class);
    }
}
