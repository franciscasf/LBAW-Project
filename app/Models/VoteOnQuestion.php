<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VoteOnQuestion extends Pivot
{
    use HasFactory;

    protected $table = 'askleic.vote_on_question';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'vote_id',
        'question_id',
    ];

    public function vote()
    {
        return $this->belongsTo(Vote::class, 'vote_id'); 
    }
}
