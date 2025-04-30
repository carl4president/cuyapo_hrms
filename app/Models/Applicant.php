<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $table = 'applicants';

    protected $fillable = [
        'app_id',
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'birth_date',
        'place_of_birth',
        'height',
        'weight',
        'blood_type',
        'gender',
        'civil_status',
        'nationality',
        'photo',
    ];

    public function contact()
    {
        return $this->hasOne(ApplicantContact::class, 'app_id', 'app_id');
    }

    public function governmentIds()
    {
        return $this->hasOne(ApplicantGovernmentIds::class, 'app_id', 'app_id');
    }

    public function familyInfo()
    {
        return $this->hasOne(ApplicantFamilyInfo::class, 'app_id', 'app_id');
    }

    public function education()
    {
        return $this->hasMany(ApplicantEducation::class, 'app_id', 'app_id');
    }

    public function employment()
    {
        return $this->hasOne(ApplicantEmployment::class, 'app_id', 'app_id');
    }

    public function children()
    {
        return $this->hasMany(ApplicantChildren::class, 'app_id', 'app_id');
    }

    public function civilServiceEligibility()
    {
        return $this->hasMany(ApplicantCivilServiceEligibility::class, 'app_id', 'app_id');
    }

    public function workExperiences()
    {
        return $this->hasMany(ApplicantWorkExperience::class, 'app_id', 'app_id');
    }

    public function voluntaryWorks()
    {
        return $this->hasMany(ApplicantVoluntaryWork::class, 'app_id', 'app_id');
    }

    public function trainings()
    {
        return $this->hasMany(ApplicantLearningDevelopmentTraining::class, 'app_id', 'app_id');
    }

    public function otherInformations()
    {
        return $this->hasMany(ApplicantOtherInformation::class, 'app_id', 'app_id');
    }

    public function interviews()
    {
        return $this->hasMany(ApplicantInterview::class, 'app_id', 'app_id');
    }



    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $latestApplicant = self::orderBy('app_id', 'desc')->first();
            $nextID = $latestApplicant ? intval(substr($latestApplicant->app_id, 4)) + 1 : 1;
            $model->app_id = 'CYP-' . sprintf("%04d", $nextID);

            \Log::info('Generated app_id: ' . $model->app_id); // Debugging log

            while (
                self::where('app_id', $model->app_id)->exists() ||
                \DB::table('applicants')->where('app_id', $model->app_id)->exists() // Check in users table
            ) {
                $nextID++;
                $model->app_id = 'CYP-' . sprintf("%04d", $nextID);
                \Log::info('Retrying app_id: ' . $model->app_id);
            }
        });
    }
}
