<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AnswerToAnswer extends Pivot
{
    
    protected $table = 'askleic.answer_to_answer';
    public $timestamps = false;

    protected $fillable = 
    [
        'answer_reply',
        'answer',
    ];

    protected $keyType = 'int';
    protected $primaryKey = ['answer_reply', 'answer'];

    public $incrementing = false;

    public function getKeyName()
    {
        return $this->primaryKey;
    }

    public function question()
    {
        return $this->belongsTo(Answer::class, 'answer');
    }
}
