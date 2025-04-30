<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantWorkExperience extends Model
{

    use HasFactory;

    protected $table = 'applicant_work_experiences';


    protected $fillable = [
        'app_id',
        'from_date',
        'to_date',
        'position_title',
        'department_agency_office_company',
        'monthly_salary',
        'salary_grade',
        'status_of_appointment',
        'govt_service'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
