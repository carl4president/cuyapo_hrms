<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantLearningDevelopmentTraining extends Model
{

    use HasFactory;

    protected $table = 'applicant_learning_development_trainings';

    protected $fillable = [
        'app_id',
        'title',
        'date_from',
        'date_to',
        'number_of_hours',
        'type_of_ld',
        'conducted_by'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'app_id', 'app_id');
    }
}
