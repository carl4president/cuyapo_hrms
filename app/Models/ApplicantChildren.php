<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantChildren extends Model
{
    use HasFactory;

    protected $table = 'applicant_children';

    protected $fillable = [
        'app_id',
        'child_name',
        'child_birthdate',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
