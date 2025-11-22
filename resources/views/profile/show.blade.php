<x-app-layout>

    <div class="max-w-xl mx-auto mt-10">

        <h1 class="text-3xl font-bold mb-2">{{ $user->name }}</h1>

        <p class="text-gray-600 mb-6">
            Joined {{ $user->created_at->format('F Y') }}
        </p>

        <h2 class="text-xl font-semibold mb-3">Tweets</h2>

        @forelse ($tweets as $tweet)
            <div class="bg-white p-4 mb-4 rounded shadow">
                <p class="text-gray-800">{{ $tweet->content }}</p>

                <small class="text-gray-500">
                    {{ $tweet->created_at->diffForHumans() }}
                </small>
            </div>
        @empty
            <p class="text-gray-500">This user has no tweets yet.</p>
        @endforelse

    </div>

</x-app-layout>
