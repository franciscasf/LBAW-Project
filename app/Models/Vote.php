<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Answer;

class Vote extends Model
{
    use HasFactory;
    protected $table = 'askleic.vote';

    protected $fillable = [
        'vote_type',
        'user_id',
    ];

    protected $primaryKey = 'vote_id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function answers()
    {
        return $this->belongsToMany(
            Answer::class, 
            'askleic.vote_on_answer', 
            'vote_id', 
            'answer_id'
        );
    }

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'vote_on_question',
            'vote_id',          
            'question_id'       
        );
    }

    public function votes()
    {
        return $this->belongsToMany(
            Vote::class, 
            'askleic.vote_on_question', 
            'question_id', 
            'vote_id'
        )->using(VoteOnQuestion::class);
    }
}
