<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AdminUser extends Model
{
    protected $table = 'askleic.admin'; 

    protected $primaryKey = 'admin_id';  

    public $timestamps = false;  

    protected $fillable = [
        'admin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');  
    }
}
