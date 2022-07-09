<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionJobTraining extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'team_id',
        'place',
        'name_leader',
        'address',
        'number',
        'start',
        'end',
        'description',
        'form',
        'transcript',
        'vaccine',
        'academic_year_id',
        'submission_status_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
