@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">

    {{-- 1. Profile Header Card --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-8">
        
        {{-- Decorative Banner/Cover --}}
        <div class="h-32 bg-gradient-to-r from-blue-900 to-blue-700"></div>

        <div class="px-8 pb-8 relative text-center">
            {{-- Avatar / Initials Wrapper --}}
            <div class="relative -mt-12 mb-4 inline-block">
                <div class="h-24 w-24 bg-white rounded-full p-1 mx-auto shadow-md">
                    <div class="h-full w-full bg-blue-50 rounded-full flex items-center justify-center text-blue-900 text-3xl font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
            </div>

            {{-- User Info --}}
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">{{ $user->name }}</h1>
            <p class="text-gray-500 text-sm mb-6">Joined {{ $user->created_at->format('F Y') }}</p>

            {{-- Stats Grid --}}
            <div class="flex justify-center gap-4 md:gap-12 border-t border-gray-100 pt-6">
                <div class="text-center px-4">
                    <span class="block text-2xl font-bold text-blue-900">
                        {{ $user->tweets->count() }}
                    </span>
                    <span class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Tweets</span>
                </div>
                <div class="text-center px-4 border-l border-gray-100">
                    <span class="block text-2xl font-bold text-blue-900">
                        {{ $user->tweets->sum(fn($t) => $t->likes->count()) }}
                    </span>
                    <span class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Total Likes</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Tweets Feed --}}
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-800 px-2">Recent Tweets</h2>

        @forelse ($tweets as $tweet)
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                
                {{-- Tweet Header (User info small) --}}
                <div class="flex items-center mb-3">
                    <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-900 text-xs font-bold mr-3">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $tweet->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                {{-- Tweet Body --}}
                <p class="text-gray-700 text-base leading-relaxed mb-4">
                    {{ $tweet->content }}
                </p>

                {{-- Action Bar (Optional - Visual Only) --}}
                <div class="flex items-center text-gray-400 text-sm gap-6 border-t border-gray-50 pt-3">
                    <div class="flex items-center gap-1 hover:text-blue-600 cursor-pointer transition-colors">
                        {{-- Heroicon Heart --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        <span>{{ $tweet->likes->count() }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <p class="text-gray-500">This user has no tweets yet.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection