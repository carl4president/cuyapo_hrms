<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddJob extends Model
{
    use HasFactory;
    protected $fillable = [
        'position_id',
        'department_id',
        'designation_id',
        'no_of_vacancies',
        'experience',
        'age',
        'salary_from',
        'salary_to',
        'job_type',
        'status',
        'start_date',
        'expired_date',
        'description',
    ];


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
