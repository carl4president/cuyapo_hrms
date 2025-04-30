<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantContact extends Model
{

    use HasFactory;

    protected $fillable = [
        'app_id', 'residential_address', 'residential_zip',
        'permanent_address', 'permanent_zip', 'phone_number', 'mobile_number'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
