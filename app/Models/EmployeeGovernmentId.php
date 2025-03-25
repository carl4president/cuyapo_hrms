<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeGovernmentId extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id', 'agency_employee_no', 'sss_no', 'gsis_id_no',
        'pagibig_no', 'philhealth_no', 'tin_no'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

