<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Answer;
use App\Models\AnswerToQuestion;
use App\Models\VoteOnQuestion;
use App\Models\Vote;
use App\Models\Tag;
use Carbon\Carbon;

class Question extends Model
{
    use HasFactory;

    protected $table = 'askleic.question';

    protected $primaryKey = 'question_id';

    public $timestamps = false;

    protected $keyType = 'int';

    protected $fillable = [
        'title', 
        'content', 
        'created_date', 
        'edited_date', 
        'author_id',
        'title_tsvectors',
        'content_tsvectors'
    ];

    protected $dates = ['created_date', 'edited_date'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($question) {
            if (!$question->created_date) {
                $question->created_date = Carbon::now();
            }
        });

        static::updating(function ($question) {
            $question->edited_date = Carbon::now();
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'user_id');
    }

    public function votes()
{
    return $this->belongsToMany(
        Vote::class, 
        'askleic.vote_on_question', 
        'question_id',              
        'vote_id'                   
    );
}
    
    public function upvotesCount()
    {
        return $this->votes()->where('vote_type', true)->count();
    }

    public function downvotesCount()
    {
        return $this->votes()->where('vote_type', false)->count();
    }

    public function answers()
    {
        return $this->belongsToMany(
            Answer::class,         
            'askleic.answer_to_question', 
            'question_id',          
            'answer_id'             
        )->using(AnswerToQuestion::class); 
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'askleic.question_has_tag', 
            'question_id',              
            'tag_id'                    
        )->as('question_tags');         
    }

    public function scopeSearch(Builder $query, $term){
    $term = preg_replace('/[^\w\sáàãâäéèêëíìîïóòôöúùûüç]/i', ' ', $term);
    $term = trim($term);
    $term = preg_replace('/(\&|\||:|!|-|\(|\))/', ' ', $term);
    $term = preg_replace('/\s+/', ' | ', $term);

    if (empty($term)) {
        session()->flash('error', 'Your search term is invalid or empty. Please try again with valid terms.');
        return redirect()->route('search');
    }

    return $query->selectRaw(
        "question.*, 
        ts_rank(question.title_tsvectors || question.content_tsvectors, to_tsquery('portuguese', ?)) AS rank"
    , [$term])
    ->leftJoin('answer_to_question', 'question.question_id', '=', 'answer_to_question.question_id')
    ->leftJoin('answer', 'answer_to_question.answer_id', '=', 'answer.answer_id')
    ->whereRaw(
        "(question.title_tsvectors || question.content_tsvectors @@ to_tsquery('portuguese', ?)) OR 
        (answer.answer_tsvectors @@ to_tsquery('portuguese', ?))",
        [$term, $term]
    )
    ->distinct()
    ->orderByDesc('rank');
}

    

    public function filterByTag($tagId)
    {
        $questions = Question::whereHas('tags', function ($query) use ($tagId) {
            $query->where('tag_id', $tagId);
        })->with('tags')->get();

        $tag = Tag::findOrFail($tagId);

        return view('questions.index', [
            'questions' => $questions,
            'tag' => $tag->name,  
        ]);
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'askleic.user_follows_question', 
            'question_id',                  
            'user_id'                       
        );
    }


}
