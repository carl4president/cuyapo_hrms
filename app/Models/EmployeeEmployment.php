<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEmployment extends Model
{
    use HasFactory;

    protected $table = 'employee_employment';

    protected $fillable = [
        'emp_id',
        'department_id',
        'designation_id',
        'position_id',
        'line_manager',
        'employment_status',
        'date_hired'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
