<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * if we want to use voting system in other models,
 * we need to move some methods to traits (like a Voter|Votable) and
 * create new table for relation morphTo
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id'
    ];

    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
