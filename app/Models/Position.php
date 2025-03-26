<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';

    protected $fillable = [
        'position_name',
        'designation_id',
        'department_id',
    ];

    public function department(){

        return $this->belongsTo(department::class);

    }

    public function designation(){

        return $this->belongsTo(Designation::class);

    }

    public function employee_employments()
    {
        return $this->hasMany(EmployeeEmployment::class, 'position_id');
    }

    public function add_job()
    {
        return $this->hasMany(AddJob::class, 'position_id');
    }
}
