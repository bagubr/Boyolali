<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;
    const STATUS_FILING = 'FILING';
    const STATUS_CEK = 'CEK';
    const STATUS_SUBKOR = 'SUBKOR';
    const STATUS_KABID = 'KABID';
    const STATUS_KADIS = 'KADIS';
    const STATUS_CETAK = 'CETAK';
    const STATUS_SELESAI = 'SELESAI';
    const STATUS_VALIDASI = [
        self::STATUS_SUBKOR,
        self::STATUS_KABID,
        self::STATUS_KADIS,
    ];
    
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
        'sketch_date',
        'kabid_date',
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
        }elseif(in_array($this->status, self::STATUS_VALIDASI)){
            return 'Tahap Validasi';
        }elseif($this->status == self::STATUS_CEK){
            return 'Tahap Pengecekan Manual';
        }elseif($this->status == self::STATUS_CETAK){
            return 'Tahap Cetak';
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
        return $this->hasMany(Riwayat::class)->orderBy('created_at');
    }

    public function interrogation_report()
    {
        return $this->hasOne(InterrogationReport::class);
    }

    public function sketch_file()
    {
        return $this->hasOne(SketchFile::class);
    }

    public function krk()
    {
        return $this->hasOne(Krk::class, 'uuid', 'uuid');
    }

    public function gsb()
    {
        return $this->hasOne(Gsb::class, 'uuid', 'uuid');
    }

    public function polygons()
    {
        return $this->hasMany(Polygon::class)->orderBy('id');
    }
}
