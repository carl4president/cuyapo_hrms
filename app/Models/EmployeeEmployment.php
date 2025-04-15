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
        'employment_status',
        'date_hired'
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
