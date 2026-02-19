<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'askleic.report';

    protected $fillable = [
        'motive',
        'report_type',
        'date',
        'reporter_id',
    ];

    protected $primaryKey = 'report_id';

    protected $keyType = 'int';

    public $timestamps = false;

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id', 'user_id');
    }

    public function question()
    {
        return $this->belongsToMany(
            Question::class,
            'askleic.question_reports',
            'report_id',
            'question_id'
        );
    }

    public function answer()
    {
        return $this->belongsToMany(
            Answer::class,
            'askleic.answer_reports',
            'report_id',
            'answer_id'
        );
    }

    public function scopePending($query)
    {
        return $query->whereDoesntHave('resolution');
    }


    public function markAsResolved()
    {
        return $this->update(['resolved' => true]);
    }
}
