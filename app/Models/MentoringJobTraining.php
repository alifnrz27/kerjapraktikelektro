<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentoringJobTraining extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'lecturer_id',
        'mentoring_status_id',
        'time',
        'description',
        'academic_year_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentoring_status()
    {
        return $this->belongsTo(MentoringStatus::class, 'id');
    }
}
