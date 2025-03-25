<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id', 'residential_address', 'residential_zip',
        'permanent_address', 'permanent_zip', 'phone_number', 'mobile_number'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

