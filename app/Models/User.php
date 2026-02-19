<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\AdminUser;
use App\Models\ModeratorUser;
use App\Models\VerifiedUser;
use App\Models\UserPostsAnswer;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $table = 'askleic.user';

    protected $primaryKey = 'user_id';


    public $timestamps = false;


    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'description',
        'profile_picture',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function admin()
    {
        return $this->hasOne(AdminUser::class, 'user_id', 'admin_id');
    }

    public function isAdmin()
    {
        return DB::table('askleic.admin')
            ->where('admin_id', $this->user_id)
            ->exists();
    }

    public function isDeleted()
    {
        return str_starts_with($this->name, 'DELETED');
    }

    public function moderator()
    {
        return $this->hasOne(ModeratorUser::class, 'user_id', 'moderator_id');
    }

    public function isModerator()
    {
        return DB::table('askleic.moderator')
            ->where('moderator_id', $this->user_id)
            ->exists();  
    }


    public function verifiedUser()
    {
        return $this->hasOne(VerifiedUser::class, 'user_id', 'user_id');
    }

    public function isVerified()
    {
        return DB::table('askleic.verified_user')
            ->where('user_id', $this->user_id)
            ->where('status', true)
            ->exists();
    }


    public function answers()
    {
        return $this->belongsToMany(
            Answer::class,
            'askleic.user_posts_answer',
            'user_id',
            'answer_id'
        )->using(UserPostsAnswer::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'author_id', 'user_id');
    }

    public function scopeSearch(Builder $query, $term)
    {

        $term = preg_replace('/[^\w\sáàãâäéèêëíìîïóòôöúùûüç]/i', ' ', $term);
        $term = trim($term);
        $term = preg_replace('/(\&|\||:|!|-|\(|\))/', ' ', $term);
        $term = preg_replace('/\s+/', ' | ', $term);

        if (empty($term)) {
            return $query->whereRaw('false');
        }

        return $query->whereRaw(
            "to_tsvector('simple', replace(name, '.', ' ')) @@ to_tsquery('simple', ?)",
            [$term]
        );
    }


    public function followedTags()
    {
        return $this->belongsToMany(
            Tag::class,
            'askleic.user_follows_tag',
            'user_id',
            'tag_id'
        )->as('followed_tags');
    }


    public function followedQuestions()
    {
        return $this->belongsToMany(
            Question::class,
            'askleic.user_follows_question',
            'user_id',
            'question_id'
        );
    }



    public function applyForVerification(Request $request)
    {
        $request->validate([
            'degree' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'id_picture' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user = auth()->user();

        if (VerifiedUser::where('user_id', $user->user_id)->exists()) {
            return redirect()->back()->with('error', 'You have already applied for verification.');
        }

        $path = $request->file('id_picture')->store('id_pictures', 'public');

        VerifiedUser::create([
            'user_id' => $user->user_id,
            'degree' => $request->degree,
            'school' => $request->school,
            'id_picture' => $path,
            'status' => false,
        ]);

        return redirect()->route('userProfile', ['id' => $user->user_id])
            ->with('success', 'Verification application submitted successfully!');
    }

    public function isVerificationPending()
    {
        $verifiedUser = $this->verifiedUser;
        return $verifiedUser && !$verifiedUser->status;
    }

    public function notifications()
{
    return $this->hasMany(Notification::class, 'user_id')->orderBy('created_at', 'desc');
}

    public function badges()
    {
        return $this->belongsToMany(
            Badge::class,
            'askleic.awarded_badges',
            'user_id',
            'badge_id'
        );
    }

    public function questionsCount()
    {
        return $this->questions()->count();
    }
    

    public function assignBadge($badgeName)
{
    $badge = Badge::where('name', $badgeName)->first();

    if ($badge && !$this->badges()
        ->where('askleic.awarded_badges.badge_id', $badge->badge_id)
        ->exists()) 
    {
        $this->badges()->attach($badge->badge_id);
    }
}




    public function isBlocked()
    {
        return DB::table('askleic.blocked_user')
            ->where('blockeduser_id', $this->user_id)
            ->exists();
    }
}
