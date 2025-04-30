<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantEducation extends Model
{
    use HasFactory;

    protected $table = 'applicant_education';

    protected $fillable = [
        'app_id', 'education_level', 'highest_education', 'degree',
        'school_name', 'year_from', 'year_to', 'highest_units_earned',
        'year_graduated', 'scholarship_honors'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
