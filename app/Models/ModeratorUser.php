<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ModeratorUser extends Model
{
    protected $table = 'askleic.moderator';

    protected $primaryKey = 'moderator_id';

    public $timestamps = false;

    protected $fillable = [
        'moderator_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'moderator_id', 'user_id');
    }
}
