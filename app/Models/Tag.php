<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'askleic.tag'; 

    protected $primaryKey = 'tag_id';

    public $timestamps = false;

    protected $keyType = 'int';

    protected $fillable = [
        'acronym', 
        'full_name', 
        'description'
    ]; 

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($tag) {
            if (strlen($tag->description) > 300) {
                throw new \InvalidArgumentException("Description must not exceed 300 characters.");
            }
        });
    }

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'askleic.question_has_tag', 
            'tag_id', 
            'question_id' 
        );
    }


    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'askleic.user_follows_tag', 
            'tag_id',           
            'user_id'           
        );
    }

    
}
