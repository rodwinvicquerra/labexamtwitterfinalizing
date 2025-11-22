<x-app-layout>

    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">

        <h1 class="text-xl font-bold mb-4">Edit Tweet</h1>

        <form action="{{ route('tweets.update', $tweet->id) }}" method="POST">
            @csrf
            @method('PUT')

            <textarea 
                name="content" 
                maxlength="280"
                class="w-full border-gray-300 rounded p-3 focus:ring-blue-500 focus:border-blue-500"
            >{{ $tweet->content }}</textarea>

            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <div class="flex items-center gap-3 mt-4">
                <button 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                >
                    Update
                </button>

                <a href="/home" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>

    </div>

</x-app-layout>
