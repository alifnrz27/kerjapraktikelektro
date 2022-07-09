<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTrainingTitle extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'lecturer_id',
        'submission_job_training_id',
        'academic_year_id',
        'title',
        'description',
        'job_training_title_status_id',
    ];
}
