<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantVoluntaryWork extends Model
{
    use HasFactory;

    protected $table = 'applicant_voluntary_works';


    protected $fillable = [
        'app_id',
        'organization_name',
        'from_date',
        'to_date',
        'number_of_hours',
        'position_nature_of_work',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
