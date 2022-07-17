<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionAfterPresentation extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'evaluate_presentation',
        'evaluate_mentoring',
        'notes',
        'official_report',
        'report_rev',
        'description',
        'submission_after_presentation_status_id',
    ];
}
