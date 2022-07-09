<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beforePresentation extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'company',
        'form',
        'logbook',
        'description',
        'academic_year_id',
        'before_presentation_status_id',
    ];
}
