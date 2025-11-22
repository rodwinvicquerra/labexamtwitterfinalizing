<x-app-layout>

    <div class="max-w-2xl mx-auto mt-10">

        {{-- Profile Header --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>

            <p class="text-gray-600">Joined: 
                {{ $user->created_at->format('F d, Y') }}
            </p>

            <p class="mt-2 text-gray-700">
                Total Tweets: <strong>{{ $user->tweets->count() }}</strong>
            </p>

            <p class="text-gray-700">
                Total Likes Received: 
                <strong>
                    {{ $user->tweets->sum(fn($t) => $t->likes->count()) }}
                </strong>
            </p>
        </div>

        {{-- User's Tweets --}}
        @foreach ($tweets as $tweet)
            <div class="bg-white p-5 rounded shadow mb-4">
                <p class="text-gray-500 text-sm">
                    {{ $tweet->created_at->diffForHumans() }}
                    @if($tweet->edited)
                        <span class="text-xs text-gray-400">(edited)</span>
                    @endif
                </p>

                <p class="mt-2 text-gray-800">{{ $tweet->content }}</p>

                <p class="text-sm text-gray-600 mt-1">
                    {{ $tweet->likes->count() }} likes
                </p>
            </div>
        @endforeach

    </div>

</x-app-layout>
