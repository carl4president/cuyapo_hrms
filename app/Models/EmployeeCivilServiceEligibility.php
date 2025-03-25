<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCivilServiceEligibility extends Model
{
    use HasFactory;

    protected $table = 'employee_civil_service_eligibility';

    protected $fillable = [
        'emp_id',
        'eligibility_type',
        'rating',
        'exam_date',
        'exam_place',
        'license_number',
        'license_validity',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }
}
