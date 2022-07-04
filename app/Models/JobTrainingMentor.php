<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTrainingMentor extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'lecturer_id',
        'academic_year_id',
    ];
}
