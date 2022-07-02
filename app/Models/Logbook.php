<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'submission_job_training_id',
        'date',
        'description',
    ];
}
