<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeOtherInformation extends Model
{
    use HasFactory;

    protected $table = 'employee_other_informations';

    protected $fillable = [
        'emp_id',
        'special_skills_hobbies',
        'non_academic_distinctions',
        'membership_associations',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }
}
