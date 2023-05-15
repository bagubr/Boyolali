<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_type', 'content', 'note', 'max_upload'
    ];


    public function applicant_reference()
    {
        return $this->hasMany(ApplicantReference::class);
    }
    
    public function user_information_reference($user_information_id)
    {
        return $this->applicant_reference()->where('user_information_id', $user_information_id)->orderBy('id', 'desc')->first();
    }
}
