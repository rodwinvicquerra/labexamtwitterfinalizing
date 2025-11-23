            @if(session('deleted'))
                <div id="tweet-success-popup" class="fixed top-8 left-1/2 transform -translate-x-1/2 bg-blue-900 px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 z-50 animate-fade-in-up" style="font-size:1.1rem; border: 2px solid #3b82f6; box-shadow: 0 8px 32px rgba(30,58,138,0.18);">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-extrabold text-blue-100 drop-shadow-lg" style="letter-spacing:1px; text-shadow: 0 2px 8px #1e3a8a;">Tweet deleted successfully!</span>
                </div>
                <script>
                    setTimeout(function() {
                        var popup = document.getElementById('tweet-success-popup');
                        if (popup) popup.style.display = 'none';
                    }, 2200);
                </script>
            @endif
        @if(session('updated'))
            <div id="tweet-success-popup" class="fixed top-8 left-1/2 transform -translate-x-1/2 bg-blue-900 px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 z-50 animate-fade-in-up" style="font-size:1.1rem; border: 2px solid #3b82f6; box-shadow: 0 8px 32px rgba(30,58,138,0.18);">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="font-extrabold text-blue-100 drop-shadow-lg" style="letter-spacing:1px; text-shadow: 0 2px 8px #1e3a8a;">Tweet updated successfully!</span>
            </div>
            <script>
                setTimeout(function() {
                    var popup = document.getElementById('tweet-success-popup');
                    if (popup) popup.style.display = 'none';
                }, 2200);
            </script>
        @endif
    @if(session('success'))
        <div id="tweet-success-popup" class="fixed top-8 left-1/2 transform -translate-x-1/2 bg-blue-900 px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 z-50 animate-fade-in-up" style="font-size:1.1rem; border: 2px solid #3b82f6; box-shadow: 0 8px 32px rgba(30,58,138,0.18);">
            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-extrabold text-blue-100 drop-shadow-lg" style="letter-spacing:1px; text-shadow: 0 2px 8px #1e3a8a;">Tweeted successfully!</span>
        </div>
        <script>
            setTimeout(function() {
                var popup = document.getElementById('tweet-success-popup');
                if (popup) popup.style.display = 'none';
            }, 2200);
        </script>
        <style>
            @keyframes fade-in-up {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in-up { animation: fade-in-up 0.5s ease; }
        </style>
    @endif
@extends('layouts.app')

@section('content')
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
            50% { transform: scale(1.1); }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
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

        .char-counter {
            transition: all 0.3s ease;
        }

        .char-counter.warning {
            color: #f59e0b;
            font-weight: 600;
        }

        .char-counter.danger {
            color: #ef4444;
            font-weight: 700;
        }

        .like-button {
            transition: transform 0.2s ease;
        }

        .like-button:active {
            animation: pulse 0.3s ease;
        }

        .tweet-textarea {
            transition: all 0.3s ease;
        }

        .tweet-textarea:focus {
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .tooltip {
            position: relative;
        }

        .tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 6px 12px;
            background: #1e3a8a;
            color: white;
            border-radius: 8px;
            font-size: 12px;
            white-space: nowrap;
            margin-bottom: 8px;
            opacity: 0;
            animation: fadeInUp 0.3s ease forwards;
        }

        .gradient-text {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glow-button {
            position: relative;
            overflow: hidden;
            background-color: #1e3a8a !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glow-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .glow-button:hover::before {
            width: 300px;
            height: 300px;
        }

        .glow-button:hover {
            background-color: #1e40af !important;
            transform: translateY(-2px);
        }

        .tweet-btn-text {
            color: white !important;
            font-weight: 800 !important;
            font-size: 1.125rem !important;
            letter-spacing: 1px;
        }
    </style>

    <div class="max-w-2xl mx-auto mt-10 px-4">
        {{-- Header Section --}}
        <div class="mb-8 fade-in-up">
            <h1 class="text-4xl font-extrabold gradient-text mb-2">What's on your mind?</h1>
            <p class="text-blue-900/60 text-sm">Share your thoughts with the world</p>
        </div>

        {{-- Create Tweet Form --}}
        <form action="{{ route('tweets.store') }}" method="POST" class="mb-10 bg-white border border-blue-900/10 p-6 rounded-2xl shadow-xl fade-in-up" style="animation-delay: 0.1s;">
            @csrf
            <div class="relative">
                <textarea 
                    name="content" 
                    maxlength="280"
                    id="tweetContent"
                    class="tweet-textarea w-full border-2 border-blue-900/20 rounded-xl p-4 text-lg font-sans focus:ring-2 focus:ring-blue-900 focus:border-blue-900 placeholder:text-blue-900/40"
                    placeholder="What's happening? ✨"
                    style="resize: none; min-height: 120px;"
                    oninput="updateCharCount(this)"
                ></textarea>
                <div class="absolute bottom-4 right-4 text-xs font-mono char-counter" id="charCounter">
                    0 / 280
                </div>
            </div>
            
            <div class="flex justify-between items-center mt-4">
                <div class="flex items-center gap-3">
                    <span class="text-xs text-blue-900/60 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Max 280 characters
                    </span>
                </div>
                @error('content')
                    <p class="text-red-500 text-xs font-semibold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            
            <button 
                type="submit"
                class="glow-button mt-4 px-10 py-3.5 rounded-full font-extrabold shadow-lg border-2 border-blue-900 transition-all duration-300"
                style="box-shadow: 0 4px 20px rgba(10,25,49,0.25);"
            >
                <span class="tweet-btn-text">Tweet</span>
            </button>
        </form>

        {{-- Timeline Header --}}
        <div class="mb-6 fade-in-up flex items-center justify-between" style="animation-delay: 0.2s;">
            <h2 class="text-2xl font-bold text-blue-900 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                Latest Tweets
            </h2>
            <span class="text-sm text-blue-900/60 font-medium">{{ $tweets->count() }} posts</span>
        </div>

        {{-- All Tweets --}}
        @foreach ($tweets as $index => $tweet)
            <div class="tweet-card bg-white border border-blue-900/10 p-6 rounded-2xl shadow-lg mb-6 fade-in-up" style="animation-delay: {{ 0.3 + ($index * 0.05) }}s;">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-900 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ strtoupper(substr($tweet->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <a href="{{ route('profile.show', $tweet->user->id) }}" class="font-bold text-blue-900 text-lg hover:underline transition">
                                {{ $tweet->user->name }}
                            </a>
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
                
                {{-- Interaction Bar --}}
                <div class="flex items-center mt-5 pt-4 border-t border-blue-900/10 gap-6">
                    {{-- Like System --}}
                    <div class="flex items-center gap-2">
                        @if ($tweet->isLikedBy(auth()->user()))
                            {{-- UNLIKE --}}
                            <form action="{{ route('tweets.unlike', $tweet->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="like-button text-2xl hover:scale-110 transition tooltip" data-tooltip="Unlike">❤️</button>
                            </form>
                        @else
                            {{-- LIKE --}}
                            <form action="{{ route('tweets.like', $tweet->id) }}" method="POST">
                                @csrf
                                <button class="like-button text-2xl text-blue-900/40 hover:text-red-500 hover:scale-110 transition tooltip" data-tooltip="Like">♡</button>
                            </form>
                        @endif
                        <span class="text-sm text-blue-900/70 font-semibold">
                            {{ $tweet->likes()->count() }}
                        </span>
                    </div>

                    {{-- Edit / Delete --}}
                    @if ($tweet->user_id === auth()->id())
                        <div class="flex gap-4 ml-auto">
                            <a 
                                href="{{ route('tweets.edit', $tweet->id) }}" 
                                class="flex items-center gap-1 text-blue-900 text-sm hover:underline font-semibold transition tooltip"
                                data-tooltip="Edit tweet"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <form 
                                action="{{ route('tweets.destroy', $tweet->id) }}" 
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this tweet?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button class="flex items-center gap-1 text-red-600 text-sm hover:underline font-semibold transition tooltip" data-tooltip="Delete tweet">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        @if($tweets->isEmpty())
            <div class="text-center py-16 fade-in-up">
                <svg class="w-20 h-20 mx-auto text-blue-900/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="text-xl font-bold text-blue-900/60 mb-2">No tweets yet</h3>
                <p class="text-blue-900/40">Be the first to share something!</p>
            </div>
        @endif
    </div>

    <script>
        function updateCharCount(textarea) {
            const counter = document.getElementById('charCounter');
            const length = textarea.value.length;
            const remaining = 280 - length;
            
            counter.textContent = `${length} / 280`;
            
            counter.classList.remove('warning', 'danger');
            if (remaining <= 20 && remaining > 0) {
                counter.classList.add('warning');
            } else if (remaining <= 0) {
                counter.classList.add('danger');
            }
        }

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection