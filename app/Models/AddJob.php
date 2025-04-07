<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AddJob extends Model
{
    use HasFactory;
    protected $fillable = [
        'position_id',
        'department_id',
        'designation_id',
        'no_of_vacancies',
        'experience',
        'age',
        'salary_from',
        'salary_to',
        'job_type',
        'status',
        'start_date',
        'expired_date',
        'description',
    ];


    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function applicants() {
        return $this->hasMany(ApplicantEmployment::class, 'position_id', 'position_id');
    }
    

    public function deleteRecord(Request $request)
    {
        try {
            AddJob::destroy($request->id);
            flash()->success('Job deleted successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Job delete fail :)');
            return redirect()->back();
        }
    }
}
