<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantCivilServiceEligibility extends Model
{
    use HasFactory;

    protected $table = 'applicant_civil_service_eligibility';

    protected $fillable = [
        'app_id',
        'eligibility_type',
        'rating',
        'exam_date',
        'exam_place',
        'license_number',
        'license_validity',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
