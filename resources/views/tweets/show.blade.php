<x-app-layout>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .tweet-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tweet-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(10, 25, 49, 0.15);
        }

        .gradient-text {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stats-card {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%) !important;
            border: 3px solid #1e3a8a !important;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            border-color: rgba(30, 58, 138, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 58, 138, 0.1);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 900;
            color: #1e3a8a !important;
            line-height: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-label {
            color: #1e3a8a !important;
            opacity: 0.7;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-avatar {
            animation: pulse 3s infinite;
        }
    </style>

    <div class="max-w-2xl mx-auto mt-10 px-4">
        {{-- Back Button --}}
        <div class="mb-6 fade-in-up">
            <a href="{{ route('tweets.index') }}" class="inline-flex items-center gap-2 text-blue-900 hover:text-blue-700 transition font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Timeline
            </a>
        </div>

        {{-- Profile Header Card --}}
        <div class="bg-white border border-blue-900/10 p-8 rounded-2xl shadow-xl mb-8 fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex items-center gap-6 mb-6">
                {{-- Large Profile Avatar --}}
                <div class="profile-avatar w-24 h-24 rounded-full bg-gradient-to-br from-blue-900 to-blue-600 flex items-center justify-center text-white font-bold text-4xl shadow-2xl flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                
                <div class="flex-1">
                    <h1 class="text-4xl font-extrabold gradient-text mb-2">{{ $user->name }}</h1>
                    <p class="text-blue-900/60 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        Joined {{ $user->created_at->format('F d, Y') }}
                    </p>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-2 gap-6 mt-8">
                {{-- Total Tweets --}}
                <div class="stats-card p-6 rounded-xl text-center">
                    <div class="stat-number" style="font-size: 3rem !important; color: #1e3a8a !important; font-weight: 900 !important; display: block;">
                        {{ $user->tweets->count() }}
                    </div>
                    <div class="stat-label mt-2" style="color: #1e3a8a !important; font-weight: 700 !important; font-size: 0.875rem !important;">
                        TOTAL TWEETS
                    </div>
                </div>

                {{-- Total Likes Received --}}
                <div class="stats-card p-6 rounded-xl text-center">
                    <div class="stat-number" style="font-size: 3rem !important; color: #1e3a8a !important; font-weight: 900 !important; display: block;">
                        {{ $user->tweets->sum(fn($t) => $t->likes->count()) }}
                    </div>
                    <div class="stat-label mt-2" style="color: #1e3a8a !important; font-weight: 700 !important; font-size: 0.875rem !important;">
                        TOTAL LIKES
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Header --}}
        <div class="mb-6 fade-in-up flex items-center gap-2" style="animation-delay: 0.2s;">
            <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <h2 class="text-2xl font-bold text-blue-900">All Tweets</h2>
            <span class="text-sm text-blue-900/60 font-medium ml-auto">{{ $tweets->count() }} posts</span>
        </div>

        {{-- User's Tweets --}}
        @foreach ($tweets as $index => $tweet)
            <div class="tweet-card bg-white border border-blue-900/10 p-6 rounded-2xl shadow-lg mb-6 fade-in-up" style="animation-delay: {{ 0.3 + ($index * 0.05) }}s;">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-900 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <span class="font-bold text-blue-900 text-lg">{{ $user->name }}</span>
                            <p class="text-blue-900/60 text-xs flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $tweet->created_at->diffForHumans() }}
                                @if($tweet->edited)
                                    <span class="text-xs text-blue-900/40 italic ml-1">(edited)</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <p class="mt-3 text-blue-900 text-base font-sans leading-relaxed pl-15">{{ $tweet->content }}</p>
                
                {{-- Like Count --}}
                <div class="flex items-center mt-5 pt-4 border-t border-blue-900/10">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-blue-900 font-bold">
                            {{ $tweet->likes->count() }} {{ $tweet->likes->count() === 1 ? 'like' : 'likes' }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach

        @if($tweets->isEmpty())
            <div class="text-center py-16 fade-in-up">
                <svg class="w-20 h-20 mx-auto text-blue-900/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="text-xl font-bold text-blue-900/60 mb-2">No tweets yet</h3>
                <p class="text-blue-900/40">This user hasn't posted anything.</p>
            </div>
        @endif
    </div>
</x-app-layout>