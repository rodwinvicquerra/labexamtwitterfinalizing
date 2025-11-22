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
            50% { transform: scale(1.05); }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
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

        .progress-bar {
            transition: width 0.3s ease;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #1e3a8a);
            border-radius: 2px;
        }

        .progress-bar.warning {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }

        .progress-bar.danger {
            background: linear-gradient(90deg, #ef4444, #dc2626);
        }

        .tweet-textarea {
            transition: all 0.3s ease;
        }

        .tweet-textarea:focus {
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
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

        .cancel-btn {
            transition: all 0.3s ease;
        }

        .cancel-btn:hover {
            background-color: rgba(30, 58, 138, 0.05);
            transform: translateY(-2px);
        }

        .edit-icon {
            animation: pulse 2s infinite;
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

        {{-- Header Section --}}
        <div class="mb-8 fade-in-up text-center" style="animation-delay: 0.1s;">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-blue-900 to-blue-600 mb-4 edit-icon">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-extrabold gradient-text mb-2">Edit Your Tweet</h1>
            <p class="text-blue-900/60 text-sm">Make your changes and update your post</p>
        </div>

        {{-- Edit Tweet Form --}}
        <form action="{{ route('tweets.update', $tweet->id) }}" method="POST" class="mb-10 bg-white border border-blue-900/10 p-6 rounded-2xl shadow-xl fade-in-up" style="animation-delay: 0.2s;">
            @csrf
            @method('PUT')
            
            <div class="relative">
                <textarea 
                    name="content" 
                    maxlength="280"
                    id="tweetContent"
                    class="tweet-textarea w-full border-2 border-blue-900/20 rounded-xl p-4 text-lg font-sans focus:ring-2 focus:ring-blue-900 focus:border-blue-900 placeholder:text-blue-900/40"
                    placeholder="What's happening? ✨"
                    style="resize: none; min-height: 150px;"
                    oninput="updateCharCount(this)"
                >{{ $tweet->content }}</textarea>
                <div class="absolute bottom-4 right-4 text-xs font-mono char-counter" id="charCounter">
                    {{ strlen($tweet->content) }} / 280
                </div>
                {{-- Progress Bar --}}
                <div class="mt-2">
                    <div class="w-full bg-blue-900/10 rounded-full h-1">
                        <div id="progressBar" class="progress-bar" style="width: {{ (strlen($tweet->content) / 280) * 100 }}%;"></div>
                    </div>
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
            
            {{-- Action Buttons --}}
            <div class="flex items-center gap-4 mt-6">
                <button 
                    type="submit"
                    class="glow-button px-10 py-3.5 rounded-full font-extrabold shadow-lg border-2 border-blue-900 transition-all duration-300"
                    style="box-shadow: 0 4px 20px rgba(10,25,49,0.25);"
                >
                    <span class="tweet-btn-text">Update Tweet</span>
                </button>
                
                <a 
                    href="{{ route('tweets.index') }}" 
                    class="cancel-btn px-8 py-3.5 rounded-full font-bold text-blue-900 border-2 border-blue-900/20 hover:border-blue-900/40 transition-all duration-300"
                >
                    Cancel
                </a>
            </div>
        </form>

        {{-- Tweet Preview Card --}}
        <div class="bg-white border border-blue-900/10 p-6 rounded-2xl shadow-lg fade-in-up" style="animation-delay: 0.3s;">
            <div class="flex items-start gap-3 mb-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-900 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-lg flex-shrink-0">
                    {{ strtoupper(substr($tweet->user->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-bold text-blue-900 text-lg">{{ $tweet->user->name }}</span>
                        <span class="text-blue-900/40 text-xs">• Preview</span>
                    </div>
                    <p class="text-blue-900/60 text-xs flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $tweet->created_at->diffForHumans() }}
                        <span class="text-xs text-blue-900/40 italic ml-1">(edited)</span>
                    </p>
                </div>
            </div>
            <div class="mt-3 pl-15">
                <p class="text-blue-900 text-base font-sans leading-relaxed bg-blue-900/5 p-4 rounded-xl border border-blue-900/10">
                    {{ $tweet->content }}
                </p>
                <p class="text-xs text-blue-900/40 mt-2 italic">↑ Current version (being edited)</p>
            </div>
        </div>
    </div>

    <script>
        function updateCharCount(textarea) {
            const counter = document.getElementById('charCounter');
            const progressBar = document.getElementById('progressBar');
            const length = textarea.value.length;
            const remaining = 280 - length;
            const percentage = (length / 280) * 100;
            
            counter.textContent = `${length} / 280`;
            progressBar.style.width = `${percentage}%`;
            
            counter.classList.remove('warning', 'danger');
            progressBar.classList.remove('warning', 'danger');
            
            if (remaining <= 20 && remaining > 0) {
                counter.classList.add('warning');
                progressBar.classList.add('warning');
            } else if (remaining <= 0) {
                counter.classList.add('danger');
                progressBar.classList.add('danger');
            }
        }

        // Initialize character count on page load
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('tweetContent');
            updateCharCount(textarea);
        });
    </script>
@endsection