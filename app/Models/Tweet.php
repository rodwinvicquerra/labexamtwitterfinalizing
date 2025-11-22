<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Like;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'edited',
    ];

    /**
     * Tweet belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tweet has many likes
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Check if the tweet is liked by a user
     */
    public function isLikedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
