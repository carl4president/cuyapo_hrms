<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeVoluntaryWork extends Model
{
    use HasFactory;

    protected $table = 'employee_voluntary_works';


    protected $fillable = [
        'emp_id',
        'organization_name',
        'from_date',
        'to_date',
        'number_of_hours',
        'position_nature_of_work',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }
}
