<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantGovernmentIds extends Model
{
    use HasFactory;

    protected $table = 'applicant_government_ids';

    protected $fillable = [
        'app_id', 'agency_employee_no', 'sss_no', 'gsis_id_no',
        'pagibig_no', 'philhealth_no', 'tin_no'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
