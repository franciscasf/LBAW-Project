<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $table = 'askleic.badge'; 

    protected $primaryKey = 'badge_id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'askleic.badge_notification', 'badge_id', 'notification_id');
    }

    public function awardedToUsers()
    {
        return $this->belongsToMany(User::class, 'askleic.awarded_badges', 'badge_id', 'user_id');
    }
}

