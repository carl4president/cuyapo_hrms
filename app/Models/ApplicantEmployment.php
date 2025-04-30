<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantEmployment extends Model
{
    use HasFactory;

    protected $table = 'applicant_employment';

    protected $fillable = [
        'app_id',
        'department_id',
        'position_id',
        'employment_status',
        'status',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'app_id', 'app_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    
}
