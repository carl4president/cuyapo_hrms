<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'department',
    ];

    public function employeeJobDetails()
    {
        return $this->hasMany(EmployeeJobDetail::class, 'department_id');
    }



    public function positions()
    {

        return $this->hasMany(Position::class, 'department_id');
    }

    public function applicant_employments()
    {
        return $this->hasMany(ApplicantEmployment::class, 'department_id');
    }

    public function add_job()
    {
        return $this->hasMany(AddJob::class, 'department_id');
    }
}
