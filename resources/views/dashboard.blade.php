

@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-8">
        {{-- Create Tweet Form --}}
        <form action="{{ route('tweets.store') }}" method="POST" class="mb-6 bg-white p-5 rounded shadow">
            @csrf
            <textarea 
                name="content" 
                maxlength="280"
                class="w-full border-gray-300 rounded p-3 focus:ring-blue-500 focus:border-blue-500"
                placeholder="What's happening?"
            ></textarea>
            <p class="text-sm text-gray-500 mt-1">Max 280 characters</p>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <button 
                class="mt-3 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
                Tweet
            </button>
        </form>
        {{-- All Tweets --}}
        @foreach ($tweets as $tweet)
            <div class="bg-white p-5 rounded shadow mb-4">
                <div class="flex justify-between items-center">
                    <a href="{{ route('profile.show', $tweet->user->id) }}" class="font-semibold text-blue-600">
                        {{ $tweet->user->name }}
                    </a>
                    <p class="text-gray-500 text-sm">
                        {{ $tweet->created_at->diffForHumans() }}
                        @if($tweet->edited)
                            <span class="text-xs text-gray-400">(edited)</span>
                        @endif
                    </p>
                </div>
                <p class="mt-2 text-gray-800">{{ $tweet->content }}</p>
                {{-- Like System --}}
                <div class="flex items-center mt-3 gap-3">
                    @if ($tweet->isLikedBy(auth()->user()))
                        {{-- UNLIKE --}}
                        <form action="{{ route('tweets.unlike', $tweet->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 text-lg">❤️</button>
                        </form>
                    @else
                        {{-- LIKE --}}
                        <form action="{{ route('tweets.like', $tweet->id) }}" method="POST">
                            @csrf
                            <button class="text-gray-600 hover:text-red-600 text-lg">♡</button>
                        </form>
                    @endif
                    {{-- Like Count --}}
                    <span class="text-sm text-gray-600">
                        {{ $tweet->likes()->count() }} likes
                    </span>
                </div>
                {{-- Edit / Delete --}}
                @if ($tweet->user_id === auth()->id())
                    <div class="flex gap-3 mt-3">
                        <a 
                            href="{{ route('tweets.edit', $tweet->id) }}" 
                            class="text-blue-600 text-sm hover:underline"
                        >
                            Edit
                        </a>
                        <form 
                            action="{{ route('tweets.destroy', $tweet->id) }}" 
                            method="POST"
                            onsubmit="return confirm('Delete this tweet?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 text-sm hover:underline">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
