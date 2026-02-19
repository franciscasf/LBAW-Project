<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';
    public $timestamps = false; 
    protected $primaryKey = 'notification_id'; 

    protected $fillable = [
        'user_id',
        'question_id',
        'answer_id',
        'responder_id',
        'created_at',
        'is_read',
        'message',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function responder()
{
    return $this->belongsTo(User::class, 'responder_id', 'user_id');
}

    
}
