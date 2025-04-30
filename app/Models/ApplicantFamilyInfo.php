<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantFamilyInfo extends Model
{

    use HasFactory;

    protected $table = 'applicant_family_info';

    protected $fillable = [
        'app_id', 'father_name', 'mother_name',
        'spouse_name', 'spouse_occupation', 'spouse_employer', 'spouse_business_address', 'spouse_tel_no',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
