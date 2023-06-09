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
    const STATUS_TOLAK = 'TOLAK';
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
        'print_date',
        'measurement_type',
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
            return 'Verifikasi Berkas';
        }elseif($this->status == self::STATUS_CEK){
            return 'Pengecekan Berkas';
        }elseif(in_array($this->status, self::STATUS_VALIDASI)){
            return 'Validasi Berkas';
        }elseif($this->status == self::STATUS_CETAK){
            return 'KRK Selesai';
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

    public function riwayat()
    {
        return $this->hasMany(Riwayat::class)->orderBy('created_at');
    }

    public function riwayat_new()
    {
        return $this->hasMany(Riwayat::class)->orderBy('created_at', 'desc');
    }

    public function approval()
    {
        return $this->hasOne(Approval::class, 'uuid', 'uuid');
    }

    public static function user_alur($status)
    {
        if($status == self::STATUS_FILING){
            return [
                self::STATUS_CEK => '&#xf00c; Cek Manual',
                self::STATUS_TOLAK => '&#xf00d; Tolak',
            ];
        }elseif($status == self::STATUS_CEK){
            return [
                self::STATUS_SUBKOR => '&#xf00c; Sub Koordinator',
                self::STATUS_FILING => '&#xf00d; Agenda',
            ];
        }elseif($status == self::STATUS_SUBKOR){
            return [
                self::STATUS_KABID => '&#xf00c; Kepala Bidang',
                self::STATUS_CEK => '&#xf00d; Cek Manual',
                self::STATUS_FILING => '&#xf00d; Agenda',
            ];
        }elseif($status == self::STATUS_KABID){
            return [
                self::STATUS_KADIS => '&#xf00c; Kepala Dinas',
                self::STATUS_SUBKOR => '&#xf00d; Sub Koordinator',
                self::STATUS_CEK => '&#xf00d; Cek Manual',
                self::STATUS_FILING => '&#xf00d; Agenda',
            ];
        }elseif($status == self::STATUS_KADIS){
            return [
                self::STATUS_CETAK => '&#xf00c; SK',
                self::STATUS_KABID => '&#xf00d; Kepala Bidang',
                self::STATUS_SUBKOR => '&#xf00d; Sub Koordinator',
                self::STATUS_CEK => '&#xf00d; Cek Manual',
                self::STATUS_FILING => '&#xf00d; Agenda',
            ];
        }else{
            return [
                self::STATUS_SELESAI => '&#xf00c; Selesai',
                self::STATUS_CETAK => '&#xf00d; SK',
                self::STATUS_KADIS => '&#xf00d; Kepala Dinas',
                self::STATUS_KABID => '&#xf00d; Kepala Bidang',
                self::STATUS_SUBKOR => '&#xf00d; Sub Koordinator',
                self::STATUS_CEK => '&#xf00d; Cek Manual',
                self::STATUS_FILING => '&#xf00d; Agenda',
            ];
        }
    }
}
