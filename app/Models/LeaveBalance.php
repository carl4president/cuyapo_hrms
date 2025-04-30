<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'leave_type',
        'total_leave_days',
        'used_leave_days',
        'remaining_leave_days',
    ];

    protected $casts = [
        'remaining_leave_days' => 'array',  // This will cast the field as an array or JSON
    ];

}
