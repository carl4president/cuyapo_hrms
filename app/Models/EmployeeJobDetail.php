<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeJobDetail extends Model
{
    use HasFactory;

    protected $table = 'employee_job_details'; // Optional, as Laravel will assume this plural form
    
    // Define the fillable fields
    protected $fillable = [
        'emp_id',
        'department_id',
        'position_id',
        'is_head',
        'is_designation',
        'appointment_date',
    ];

    // Define the relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
