<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Tweet $tweet)
    {
        auth()->user()->likes()->create([
            'tweet_id' => $tweet->id
        ]);

        return back();
    }

    public function unlike(Tweet $tweet)
    {
        auth()->user()->likes()
            ->where('tweet_id', $tweet->id)
            ->delete();

        return back();
    }
}
