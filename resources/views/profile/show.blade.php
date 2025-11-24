@extends('layouts.app')

@php
    $hideGroupsPanel = true;
@endphp

@section('content')
<div class="max-w-2xl mx-auto py-6 px-4">

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
            {{-- Circles affiliation --}}
            @if($user->groups->count())
                <div class="mt-4 border-t border-blue-700 pt-4">
                    <h3 class="text-sm text-blue-200 mb-2">Member of</h3>
                    <div class="flex justify-center gap-2 flex-wrap">
                        @foreach($user->groups as $group)
                            <a href="#" class="bg-white text-blue-900 px-3 py-1 rounded-full text-sm font-semibold border border-blue-700">{{ $group->name }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

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

    {{-- 2. Pending Circle Requests (Only for circle authors) --}}
    @if(auth()->check() && auth()->id() === $user->id && $ownedCircles->count() > 0)
        @php
            $totalPendingRequests = $ownedCircles->sum(fn($circle) => $circle->pendingRequests()->count());
        @endphp
        @if($totalPendingRequests > 0)
            <div class="bg-white border-4 border-blue-800 rounded-xl p-5 shadow-lg mb-6">
                <button 
                    onclick="togglePendingRequests()" 
                    class="w-full flex items-center justify-between text-left"
                >
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-blue-900">Pending Join Requests</h3>
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $totalPendingRequests }}</span>
                    </div>
                    <svg id="pendingRequestsIcon" class="w-5 h-5 text-blue-900 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="pendingRequestsList" style="display: none;" class="mt-4 space-y-3">
                    @foreach($ownedCircles as $circle)
                        @php
                            $requests = $circle->pendingRequests()->get();
                        @endphp
                        @if($requests->count() > 0)
                            <div class="border-t border-blue-200 pt-3">
                                <h4 class="font-bold text-sm text-blue-900 mb-2">{{ $circle->name }}</h4>
                                <ul class="space-y-2">
                                    @foreach($requests as $request)
                                        <li class="flex items-center justify-between bg-blue-50 p-3 rounded-lg">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-blue-900 flex items-center justify-center text-white font-bold">
                                                    {{ substr($request->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-sm text-blue-900">{{ $request->user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $request->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                <form action="{{ route('groups.requests.approve', $request) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-blue-900 text-white text-sm font-bold rounded-lg hover:bg-blue-800 transition shadow-md">
                                                        Accept
                                                    </button>
                                                </form>
                                                <form action="{{ route('groups.requests.decline', $request) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-white text-blue-900 border-2 border-blue-900 text-sm font-bold rounded-lg hover:bg-blue-50 transition shadow-md">
                                                        Decline
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    @endif

    {{-- 3. Tweets Feed --}}
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

<script>
function togglePendingRequests() {
    const list = document.getElementById('pendingRequestsList');
    const icon = document.getElementById('pendingRequestsIcon');
    
    if (list.style.display === 'none') {
        list.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
    } else {
        list.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>
@endsection
