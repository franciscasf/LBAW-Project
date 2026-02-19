<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VoteOnAnswer extends Pivot
{
    use HasFactory;

    protected $table = 'askleic.vote_on_answer';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'vote_id',
        'answer_id',
    ];
}