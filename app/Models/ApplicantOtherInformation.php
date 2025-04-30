<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantOtherInformation extends Model
{

    use HasFactory;

    protected $table = 'applicant_other_informations';

    protected $fillable = [
        'app_id',
        'special_skills_hobbies',
        'non_academic_distinctions',
        'membership_associations',
    ];


    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
