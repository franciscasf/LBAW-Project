<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserPostsAnswer extends Pivot
{
    protected $table = 'askleic.user_posts_answer';

    public $timestamps = false;

    protected $fillable = [
        'answer_id',
        'user_id',
    ];

    protected $keyType = 'int';
    protected $primaryKey = ['answer_id', 'user_id'];

    public function getKeyName()
    {
        return $this->primaryKey;
    }
}
