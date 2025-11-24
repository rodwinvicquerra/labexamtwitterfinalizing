<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id', // owner
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function joinRequests()
    {
        return $this->hasMany(GroupJoinRequest::class);
    }

    public function pendingRequests()
    {
        return $this->joinRequests()->where('status', 'pending')->with('user');
    }
}
