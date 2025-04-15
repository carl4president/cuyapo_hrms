<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';

    protected $fillable = [
        'position_name',
        'department_id',
    ];

    public function department(){

        return $this->belongsTo(department::class);

    }

    public function jobDetails(){

        return $this->hasMany(EmployeeJobDetail::class, 'position_id');

    }


    public function add_job()
    {
        return $this->hasMany(AddJob::class, 'position_id');
    }
}
