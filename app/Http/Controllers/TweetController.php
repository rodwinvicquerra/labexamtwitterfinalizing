<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TweetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ---------------------------------------------------------
    // SHOW TIMELINE
    // ---------------------------------------------------------
    public function index()
    {
        $tweets = Tweet::with(['user', 'likes'])
            ->latest()
            ->get();

        return view('tweets.index', compact('tweets'));
    }

    // ---------------------------------------------------------
    // CREATE TWEET
    // ---------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:280',
        ]);

        Tweet::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Tweet posted!');
    }

    // ---------------------------------------------------------
    // EDIT TWEET
    // ---------------------------------------------------------
    public function edit(Tweet $tweet)
    {
        abort_if($tweet->user_id !== auth()->id(), 403);

        return view('tweets.edit', compact('tweet'));
    }

    // ---------------------------------------------------------
    // UPDATE TWEET
    // ---------------------------------------------------------
    public function update(Request $request, Tweet $tweet)
    {
        abort_if($tweet->user_id !== auth()->id(), 403);

        $request->validate([
            'content' => 'required|max:280',
        ]);

        $tweet->update([
            'content' => $request->content,
            'edited' => true,
        ]);

        return redirect()->route('home')
            ->with('success', 'Tweet updated!');
    }

    // ---------------------------------------------------------
    // DELETE TWEET
    // ---------------------------------------------------------
    public function destroy(Tweet $tweet)
    {
        abort_if($tweet->user_id !== auth()->id(), 403);

        $tweet->delete();

        return back()->with('success', 'Tweet deleted.');
    }
}
