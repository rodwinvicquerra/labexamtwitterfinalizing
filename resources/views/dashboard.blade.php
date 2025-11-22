

@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-10">
        {{-- Create Tweet Form --}}
        <form action="{{ route('tweets.store') }}" method="POST" class="mb-8 bg-white border border-blue-900/10 p-6 rounded-xl shadow-lg">
            @csrf
            <textarea 
                name="content" 
                maxlength="280"
                class="w-full border-2 border-blue-900/20 rounded-xl p-4 text-lg font-sans focus:ring-blue-900 focus:border-blue-900 placeholder:text-blue-900/60"
                placeholder="What's happening?"
                style="resize: none; min-height: 80px;"
            ></textarea>
            <div class="flex justify-between items-center mt-2">
                <p class="text-xs text-blue-900/60">Max 280 characters</p>
                @error('content')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>
            <button 
                class="mt-4 bg-blue-900 text-blue-900 px-8 py-3 rounded-full font-extrabold shadow-lg border-2 border-blue-900 hover:bg-blue-800 hover:text-blue-800 transition focus:outline-none focus:ring-2 focus:ring-blue-900"
                style="box-shadow: 0 4px 16px rgba(10,25,49,0.18); letter-spacing: 0.5px;"
            >
                Tweet
            </button>
        </form>
        {{-- All Tweets --}}
        @foreach ($tweets as $tweet)
            <div class="bg-white border border-blue-900/10 p-6 rounded-xl shadow-lg mb-6">
                <div class="flex justify-between items-center mb-2">
                    <a href="{{ route('profile.show', $tweet->user->id) }}" class="font-bold text-blue-900 text-lg hover:underline">
                        {{ $tweet->user->name }}
                    </a>
                    <p class="text-blue-900/60 text-xs">
                        {{ $tweet->created_at->diffForHumans() }}
                        @if($tweet->edited)
                            <span class="text-xs text-blue-900/40">(edited)</span>
                        @endif
                    </p>
                </div>
                <p class="mt-2 text-blue-900 text-base font-sans">{{ $tweet->content }}</p>
                {{-- Like System --}}
                <div class="flex items-center mt-4 gap-4">
                    @if ($tweet->isLikedBy(auth()->user()))
                        {{-- UNLIKE --}}
                        <form action="{{ route('tweets.unlike', $tweet->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-blue-900 text-xl">❤️</button>
                        </form>
                    @else
                        {{-- LIKE --}}
                        <form action="{{ route('tweets.like', $tweet->id) }}" method="POST">
                            @csrf
                            <button class="text-blue-900/40 hover:text-blue-900 text-xl">♡</button>
                        </form>
                    @endif
                    {{-- Like Count --}}
                    <span class="text-sm text-blue-900/60">
                        {{ $tweet->likes()->count() }} likes
                    </span>
                </div>
                {{-- Edit / Delete --}}
                @if ($tweet->user_id === auth()->id())
                    <div class="flex gap-4 mt-4">
                        <a 
                            href="{{ route('tweets.edit', $tweet->id) }}" 
                            class="text-blue-900 text-sm hover:underline font-semibold"
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
                            <button class="text-red-600 text-sm hover:underline font-semibold">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
