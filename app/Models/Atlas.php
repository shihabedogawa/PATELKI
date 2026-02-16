<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atlas extends Model
{
    //

protected $fillable = [
    'title',
    'type',
    'content',
    'is_active',
];


public function quizAnswers()
{
    return $this->hasMany(QuizAnswer::class);
}

}
