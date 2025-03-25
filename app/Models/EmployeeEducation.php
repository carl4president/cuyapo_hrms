<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEducation extends Model
{
    use HasFactory;

    protected $table = 'employee_education';

    protected $fillable = [
        'emp_id', 'education_level', 'highest_education', 'degree',
        'school_name', 'year_from', 'year_to', 'highest_units_earned',
        'year_graduated', 'scholarship_honors'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
