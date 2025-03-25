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

    public function designations()
    {

        return $this->hasMany(Designation::class);
    }

    public function position()
    {

        return $this->hasMany(Position::class);
    }

    public function employee_employments()
    {
        return $this->hasMany(EmployeeEmployment::class, 'department_id');
    }
}
