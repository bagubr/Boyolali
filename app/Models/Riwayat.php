<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;
    protected $table = 'riwayat';
    protected $fillable = [
        'from', 'to', 'from_id', 'note', 'user_information_id'
    ];

    protected $appends = [
        'keterangan_status'
    ];

    public function getKeteranganStatusAttribute()
    {
        if($this->to == UserInformation::STATUS_FILING){
            return 'Tahap Berkas';
        }elseif($this->to == UserInformation::STATUS_CEK){
            return 'Tahap Pengecekan Manual';
        }elseif($this->to == UserInformation::STATUS_SUBKOR){
            return 'Tahap Validasi Subkor';
        }elseif($this->to == UserInformation::STATUS_KABID){
            return 'Tahap Validasi Kabid';
        }elseif($this->to == UserInformation::STATUS_KADIS){
            return 'Tahap Validasi Kadis';
        }elseif($this->to == UserInformation::STATUS_CETAK){
            return 'Tahap Cetak';
        }else{
            return $this->to;
        }
    }

    public function user_information()
    {
        return $this->belongsTo(UserInformation::class);
    }

    public function dari()
    {
        return $this->belongsTo(Administrator::class, 'from_id');
    }
}
