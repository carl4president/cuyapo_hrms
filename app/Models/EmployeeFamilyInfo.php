<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFamilyInfo extends Model
{
    protected $table = 'employee_family_info';
    use HasFactory;

    protected $fillable = [
        'emp_id', 'father_name', 'mother_name',
        'spouse_name', 'spouse_occupation', 'spouse_employer', 'spouse_business_address', 'spouse_tel_no',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
