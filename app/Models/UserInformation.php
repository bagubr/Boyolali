<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;
    const STATUS_FILING = 'FILING';
    const STATUS_SURVEI = 'SURVEI';
    const STATUS_SKETCH = 'SKETCH';
    const STATUS_REPORT = 'REPORT';
    const STATUS_SIDANG = 'SIDANG';
    const STATUS_PRINT = 'PRINT';
    const STATUS_APPROVAL = 'APPROVAL';
    const STATUS_SELESAI = 'SELESAI';
    
    protected $table = 'user_informations';
    protected $fillable = [
        'uuid',
        'nomor_registration', 
        'nomor_krk', 
        'nomor_hak', 
        'submitter', 
        'address',
        'location_address',
        'land_area',
        'latitude',
        'longitude',
        'activity_name',
        'kbli_activity_id',
        'district_id',
        'sub_district_id',
        'land_status_id',
        'user_id',
        'nomor_ktp',
        'submitter_phone',
        'status',
        'nomor',
        'agenda_date',
        'survei_date',
    ];

    protected $appends = [
        'keterangan_status',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = \Str::uuid();
        });
    }

    public function getKeteranganStatusAttribute()
    {
        if($this->status == self::STATUS_FILING){
            return 'Tahap Berkas';
        }elseif($this->status == self::STATUS_SURVEI){
            return 'Tahap Survei';
        }elseif($this->status == self::STATUS_SKETCH){
            return 'Tahap Gambar';
        }else{
            return $this->status;
        }
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function kbli_activity()
    {
        return $this->belongsTo(KbliActivity::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function land_status()
    {
        return $this->belongsTo(LandStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function procuration()
    {
        return $this->hasOne(Procuration::class);
    }

    public function applicant_reference()
    {
        return $this->hasMany(ApplicantReference::class);
    }

    public function revision()
    {
        return $this->hasMany(Revision::class)->orderBy('created_at');
    }

    public function interrogation_report()
    {
        return $this->hasOne(InterrogationReport::class);
    }
}
