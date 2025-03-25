<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $table = 'designations';

    protected $fillable = [
        'designation_name',
        'department_id',
    ];

    public function department(){

        return $this->belongsTo(department::class);

    }

    public function position(){

        return $this->hasMany(Position::class);

    }

    public function employee_employments()
    {
        return $this->hasMany(EmployeeEmployment::class, 'department_id');
    }


}
