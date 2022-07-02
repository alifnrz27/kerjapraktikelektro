<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyLetter extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'user_id',
        'from_major',
        'from_company',
    ];
}
