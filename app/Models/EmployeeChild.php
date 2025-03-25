<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeChild extends Model

{

    use HasFactory;

    protected $table = 'employee_children';

    protected $fillable = [
        'emp_id',
        'child_name',
        'child_birthdate',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


}
