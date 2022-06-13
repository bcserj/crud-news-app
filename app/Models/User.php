<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function votes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * @param  Builder $query
     * @param  $email
     * @return Builder
     */
    public function scopeWithEmail(Builder $query, string $email): Builder
    {
        return $query->where('email', $email);
    }

    public function upvote(Post $post): bool
    {
        if (!$this->hasVoted($post)) {
            $vote = new Vote();
            $vote->user_id = $this->getKey();
            $voteItem = $post->votes()->save($vote);

            if ($voteItem) {
                return true;
            }
        }

        return false;
    }

    public function downVote(Post $post): bool
    {
        if ($this->hasVoted($post)) {
            $vote = ($post->relationLoaded('votes') ? $post->votes : $post->votes())
                ->where('user_id', $this->getKey())
                ->first();

            if ($vote) {
                $vote->delete();
                return true;
            }
        }
        return false;
    }

    public function hasVoted(Post $post): bool
    {
        return ($this->relationLoaded('votes') ? $this->votes : $this->votes())
                ->where('post_id', $post->getKey())
                ->count() > 0;
    }
}
