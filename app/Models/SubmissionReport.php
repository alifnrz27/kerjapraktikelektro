<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'lecturer_id',
        'report',
        'description',
        'academic_year_id',
        'submission_report_status_id',
    ];
}
