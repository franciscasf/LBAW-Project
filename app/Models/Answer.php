<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\UserPostsAnswers;
use App\Models\Vote;
use App\Models\VoteOnAnswer;
use App\Models\AnswerToAnswer;

class Answer extends Model
{
    protected $table = 'askleic.answer';

    protected $primaryKey = 'answer_id';

    public $timestamps = false;  

    protected $keyType = 'int';

    protected $fillable = [ 
        'content', 
        'created_date', 
        'edited_date', 
        'verified',
        'answer_tsvectors'
    ];

    protected $dates = ['created_date', 'edited_date'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($answer)
        {
            if(!$answer->created_date)
            {
                $answer->created_date = Carbon::now();
            }

            if(!$answer->verified)
            {
                $answer->verified = FALSE;
            }


        });

        static::updating(function($answer)
        {
            $answer->edited_date = Carbon::now(); 
        });

        static::deleting(function($answer) {

            $answer->votes()->delete();
            $answer->users()->delete();
            $answer->answerToQuestion()->delete();
        });

    }

    public function users()
    {
        return $this->belongsToMany(
            User::class, 
            'askleic.user_posts_answer', 
            'answer_id',                 
            'user_id'                    
        )->using(UserPostsAnswer::class);
    }

    public function author()
    {
        return $this->hasOneThrough(
            User::class,                    
            UserPostsAnswer::class,        
            'answer_id',                   
            'user_id',                      
            'answer_id',                   
            'user_id'                       
        );
    }

    public function votes()
{
    return $this->belongsToMany(
        Vote::class,
        'askleic.vote_on_answer',
        'answer_id',
        'vote_id'
    )->select(
        'askleic.vote.*',
        'askleic.vote_on_answer.answer_id as vote_answer_id'
    );
}


    public function isVerified()
    {
        return $this->verified === true;
    }

    public function question()
    {
    return $this->hasOne(AnswerToQuestion::class, 'answer_id', 'answer_id');
    }

    public function mother_answer()
    {
        return $this->belongsToMany(
            Answer::class,          
            'askleic.answer_to_answer',  
            'answer_reply',         
            'answer'        
        )->using(AnswerToAnswer::class); 
    }

    public function getQuestionId()
{
    if ($this->question) {
        return $this->question->question_id;
    }

    $motherAnswer = $this->mother_answer()->first();

    if ($motherAnswer && $motherAnswer->question) {
        return $motherAnswer->question->question_id;
    }
    return null;
}


    public function answerToQuestion()
    {
        return $this->hasOne(AnswerToQuestion::class, 'answer_id'); 
    }

    public function verify()
    {
        if ($this->verified) {
            throw new \Exception('Answer is already verified.');
        }

        $this->verified = true;

        $this->save();

        return $this;
    }

    public function answers()
    {
        return $this->belongsToMany(
            Answer::class,         
            'askleic.answer_to_answer', 
            'answer',          
            'answer_reply'             
        )->using(AnswerToAnswer::class); 
    }


    public function getReplyCount()
    {
        return $this->answers()->count(); 
    }

    public function getUpvotesAttribute()
{
    return $this->votes()->where('vote_type', true)->count();
}

public function getDownvotesAttribute()
{
    return $this->votes()->where('vote_type', false)->count();
}

public function upvotesCount()
{
    return $this->votes()
        ->where('askleic.vote.vote_type', true)
        ->count();
}

public function downvotesCount()
{
    return $this->votes()
        ->where('askleic.vote.vote_type', false)
        ->count();
}

}
