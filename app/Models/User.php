<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Tweet;
use App\Models\Like;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * User has many Tweets.
     */
    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    /**
     * User has many Likes.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Groups the user belongs to.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }
}
