@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-6 px-4">

    {{-- 1. Profile Header Card --}}
    <div class="bg-blue-900 border-4 border-blue-900 rounded-2xl shadow-xl overflow-hidden mb-8">
        
        {{-- Cover Banner --}}
        <div class="h-24 bg-gradient-to-r from-blue-700 to-blue-500"></div>

        <div class="px-6 pb-6 relative text-center">
            {{-- Avatar --}}
            <div class="relative -mt-10 mb-3 inline-block">
                <div class="h-20 w-20 bg-blue-900 rounded-full p-1 mx-auto shadow-md border-4 border-white">
                    <div class="h-full w-full bg-white rounded-full flex items-center justify-center text-blue-900 text-lg font-bold px-2 text-center">
                        {{ $user->name }}
                    </div>
                </div>
            </div>

            {{-- User Info --}}
            <h1 class="text-2xl font-extrabold text-white">{{ $user->name }}</h1>
            <p class="text-blue-200 text-sm mb-4">Joined {{ $user->created_at->format('F Y') }}</p>

            {{-- Stats (Updated colors) --}}
            <div class="flex justify-center gap-6 border-t border-blue-700 pt-4">

                {{-- Total Tweets --}}
                <div class="text-center px-4">
                    <span class="block font-black text-white"
                          style="font-size: 2rem !important; line-height: 1.2 !important;">
                        {{ $user->tweets->count() }}
                    </span>
                    <span class="text-xs text-blue-300 uppercase tracking-wide font-semibold mt-1 block">Tweets</span>
                </div>

                {{-- Total Likes --}}
                <div class="text-center px-4 border-l border-blue-700">
                    <span class="block font-black text-white"
                          style="font-size: 2rem !important; line-height: 1.2 !important;">
                        {{ $user->tweets->sum(fn($t) => $t->likes->count()) }}
                    </span>
                    <span class="text-xs text-blue-300 uppercase tracking-wide font-semibold mt-1 block">Total Likes</span>
                </div>

            </div>
        </div>
    </div>

    {{-- 2. Tweets Feed --}}
    <div class="space-y-4">
        <h2 class="text-xl font-extrabold text-blue-900 px-1 mb-2">Recent Tweets</h2>

        @forelse ($tweets as $tweet)
            <div class="bg-white border-4 border-blue-800 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all duration-200">
                
                {{-- Tweet Header --}}
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-blue-900 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3 shadow-sm">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-base font-bold text-blue-900">{{ $user->name }}</p>
                            <p class="text-xs text-blue-600 font-semibold">{{ $tweet->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    {{-- Edit button --}}
                    @if(auth()->id() === $tweet->user_id)
                        <a href="{{ route('tweets.edit', $tweet->id) }}" class="text-blue-400 hover:text-blue-900 hover:bg-blue-50 p-2 rounded-full transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>
                    @endif
                </div>

                {{-- Tweet Body --}}
                <div class="pl-1">
                    <p class="text-blue-900 text-base leading-relaxed font-medium">
                        {{ $tweet->content }}
                    </p>
                </div>

                {{-- Likes Bar --}}
                <div class="flex items-center text-blue-800 text-sm gap-6 border-t border-blue-100 pt-3 mt-4">
                    <div class="flex items-center gap-1 hover:text-blue-600 cursor-pointer font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        <span style="font-weight: 800 !important; font-size: 0.95rem !important;">
                            {{ $tweet->likes->count() }} Likes
                        </span>
                    </div>
                </div>

            </div>
        @empty
            <div class="text-center py-10 bg-blue-50 rounded-xl border-2 border-dashed border-blue-900">
                <p class="text-blue-900 font-semibold">This user has no tweets yet.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
