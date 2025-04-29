<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
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
        'nationality'
    ];

    public function contact()
    {
        return $this->hasOne(EmployeeContact::class, 'emp_id', 'emp_id');
    }

    public function governmentIds()
    {
        return $this->hasOne(EmployeeGovernmentId::class, 'emp_id', 'emp_id');
    }

    public function familyInfo()
    {
        return $this->hasOne(EmployeeFamilyInfo::class, 'emp_id', 'emp_id');
    }

    public function education()
    {
        return $this->hasMany(EmployeeEducation::class, 'emp_id', 'emp_id');
    }

    public function employment()
    {
        return $this->hasOne(EmployeeEmployment::class, 'emp_id', 'emp_id');
    }

    public function children()
    {
        return $this->hasMany(EmployeeChild::class, 'emp_id', 'emp_id');
    }

    public function civilServiceEligibility()
    {
        return $this->hasMany(EmployeeCivilServiceEligibility::class, 'emp_id', 'emp_id');
    }

    public function workExperiences()
    {
        return $this->hasMany(EmployeeWorkExperience::class, 'emp_id', 'emp_id');
    }

    public function voluntaryWorks()
    {
        return $this->hasMany(EmployeeVoluntaryWork::class, 'emp_id', 'emp_id');
    }

    public function trainings()
    {
        return $this->hasMany(EmployeeLearningDevelopmentTraining::class, 'emp_id', 'emp_id');
    }

    public function otherInformations()
    {
        return $this->hasMany(EmployeeOtherInformation::class, 'emp_id', 'emp_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'emp_id', 'user_id');
    }

    public function jobDetails()
    {
        return $this->hasMany(EmployeeJobDetail::class, 'emp_id', 'emp_id');
    }




    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $latestEmployee = self::orderBy('emp_id', 'desc')->first();
            $nextID = $latestEmployee ? intval(substr($latestEmployee->emp_id, 4)) + 1 : 1;
            $model->emp_id = 'CYP-' . sprintf("%04d", $nextID);

            \Log::info('Generated emp_id: ' . $model->emp_id); // Debugging log

            while (
                self::where('emp_id', $model->emp_id)->exists() ||
                \DB::table('users')->where('user_id', $model->emp_id)->exists() // Check in users table
            ) {
                $nextID++;
                $model->emp_id = 'CYP-' . sprintf("%04d", $nextID);
                \Log::info('Retrying emp_id: ' . $model->emp_id);
            }
        });
    }
}
