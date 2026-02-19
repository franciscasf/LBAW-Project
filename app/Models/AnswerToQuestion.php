<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AnswerToQuestion extends Pivot
{
    protected $table = 'askleic.answer_to_question';
    public $timestamps = false;

    protected $fillable = 
    [
        'answer_id',
        'question_id',
    ];

    protected $keyType = 'int';
    protected $primaryKey = ['answer_id', 'question_id'];

    public $incrementing = false;

    public function getKeyName()
    {
        return $this->primaryKey;
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
