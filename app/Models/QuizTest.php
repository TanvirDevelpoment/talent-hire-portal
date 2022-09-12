<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'quiz_test_details',
        'quiz_perform_qty',
        'quiz_pass_qty',
        'total_marks_aquired',
        'time_consumed',
        'total_questions',
        'user_id',        
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
