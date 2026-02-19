<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{
    protected $table = 'askleic.blocked_user';
    public $timestamps = false;
    protected $primaryKey = 'blockeduser_id';
    protected $fillable = ['blockeduser_id'];


}
