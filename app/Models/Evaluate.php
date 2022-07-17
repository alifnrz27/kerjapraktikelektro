<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{
    use HasFactory;
    protected $fillable = [
        'academic_year_id',
        'student_id',
        'lecturer_id',
        'understanding_score',
        'analysis_score',
        'report_score',
        'description_mentoring',
        'presentation_score',
        'content_score',
        'qna_score',
        'description_presentation',
    ];
}
