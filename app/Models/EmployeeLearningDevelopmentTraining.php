<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLearningDevelopmentTraining extends Model
{
    use HasFactory;

    protected $table = 'employee_learning_development_trainings';

    protected $fillable = [
        'emp_id',
        'title',
        'date_from',
        'date_to',
        'number_of_hours',
        'type_of_ld',
        'conducted_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }
}
