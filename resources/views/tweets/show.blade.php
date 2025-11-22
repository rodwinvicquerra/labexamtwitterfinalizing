<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 px-4">

        {{-- 1. IMPROVED PROFILE HEADER --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="p-8 text-center">
                
                {{-- Avatar / Initials --}}
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-100 text-blue-600 text-2xl font-bold mb-4">
                    {{ substr($user->name, 0, 1) }}
                </div>

                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-gray-500 text-sm mt-1">Joined {{ $user->created_at->format('F Y') }}</p>

                {{-- Stats Grid --}}
                <div class="flex justify-center gap-8 mt-6 border-t border-gray-100 pt-6">
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-gray-800">{{ $user->tweets->count() }}</span>
                        <span class="text-xs text-gray-500 uppercase tracking-wide">Tweets</span>
                    </div>
                    <div class="text-center px-6 border-l border-gray-100">
                        {{-- Calculates total likes safely in the view --}}
                        <span class="block text-2xl font-bold text-gray-800">
                            {{ $user->tweets->sum(fn($t) => $t->likes->count()) }}
                        </span>
                        <span class="text-xs text-gray-500 uppercase tracking-wide">Total Likes</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. IMPROVED TWEET LIST --}}
        <h2 class="text-lg font-semibold text-gray-700 mb-4 ml-1">Recent Activity</h2>

        <div class="space-y-4">
            @forelse ($tweets as $tweet)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:border-blue-300 transition-colors duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="font-bold text-gray-900">{{ $user->name }}</span>
                            <span class="text-gray-400 text-sm ml-2">&bull; {{ $tweet->created_at->diffForHumans() }}</span>
                            @if($tweet->created_at != $tweet->updated_at)
                                <span class="text-xs text-gray-400 italic ml-1">(edited)</span>
                            @endif
                        </div>
                    </div>

                    <p class="mt-3 text-gray-800 text-lg leading-relaxed">{{ $tweet->content }}</p>

                    <div class="mt-4 flex items-center text-gray-500 text-sm">
                        {{-- Like Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                        {{-- Likes Count --}}
                        <span>{{ $tweet->likes->count() }}</span>
                    </div>
                </div>
            @empty
                {{-- 3. EMPTY STATE --}}
                <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500">This user hasn't posted any tweets yet.</p>
                </div>
            @endforelse
        </div>
        
        {{-- Pagination links removed to prevent crash --}}

    </div>
</x-app-layout>