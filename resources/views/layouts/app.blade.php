<!DOCTYPE html>
<html>
<head>
    <title>Mini Twitter</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-white p-4 shadow mb-6">
    <div class="max-w-4xl mx-auto flex justify-between">
        <a href="{{ route('home') }}" class="font-bold text-blue-600">Home</a>

        <div class="flex space-x-4">
            <a href="/user/{{ auth()->id() }}" class="text-gray-600">My Profile</a>
            <form action="/logout" method="POST">
                @csrf
                <button class="text-red-500">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="max-w-4xl mx-auto">
    @yield('content')
</div>

</body>
</html>
