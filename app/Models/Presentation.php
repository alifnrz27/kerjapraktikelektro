<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'lecturer_id',
        'date',
        'description',
        'academic_year_id',
        'presentation_status_id',
    ];
}
