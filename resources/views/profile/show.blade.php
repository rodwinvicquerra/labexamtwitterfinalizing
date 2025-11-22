@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-2">{{ $user->name }}</h1>
        <p class="text-gray-600 mb-2">
            Joined {{ $user->created_at->format('F Y') }}
        </p>
        <div class="mb-6 flex gap-6">
            <span class="text-blue-600 font-semibold">Tweets: {{ $user->tweets->count() }}</span>
            <span class="text-pink-600 font-semibold">Total Likes Received: {{ $user->tweets->sum(fn($t) => $t->likes->count()) }}</span>
        </div>
        <h2 class="text-xl font-semibold mb-3">Tweets</h2>
        @forelse ($tweets as $tweet)
            <div class="bg-white p-4 mb-4 rounded shadow">
                <p class="text-gray-800">{{ $tweet->content }}</p>
                <small class="text-gray-500">
                    {{ $tweet->created_at->diffForHumans() }}
                </small>
            </div>
        @empty
            <p class="text-gray-500">This user has no tweets yet.</p>
        @endforelse
    </div>

