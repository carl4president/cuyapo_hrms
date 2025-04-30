<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantInterview extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_id', 
        'interview_date', 
        'interview_time', 
        'location', 
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'app_id', 'app_id');
    }
}
