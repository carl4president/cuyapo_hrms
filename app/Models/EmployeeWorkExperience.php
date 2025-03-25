<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeWorkExperience extends Model
{
    use HasFactory;

    protected $table = 'employee_work_experiences';


    protected $fillable = [
        'emp_id',
        'from_date',
        'to_date',
        'position_title',
        'department_agency_office_company',
        'monthly_salary',
        'salary_grade',
        'status_of_appointment',
        'govt_service'
    ];

    /**
     * Relationship: A work experience belongs to an employee.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
