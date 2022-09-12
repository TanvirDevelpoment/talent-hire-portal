<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'options_type',
        'options',
        'correct_option',
        'mark',
        'status',
        'user_id',        
    ];
}
