<!DOCTYPE html>
<html>
<head>
    <title>Mini Twitter</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen font-sans">

<nav class="bg-blue-900 p-4 shadow mb-8">
    <div class="max-w-4xl mx-auto flex flex-col gap-2">
        <div class="w-full flex justify-center items-center gap-3 mb-2">
            <img src="/twitterlogo.png" alt="Twitter Logo" class="h-8 w-8 inline-block align-middle">
            <span class="font-extrabold text-blue-900 text-xl tracking-tight">Twitter ni Rodwin</span>
        </div>
        <div class="flex justify-between items-center">
            <a href="{{ route('home') }}" class="font-bold text-blue-900 text-xl tracking-tight bg-white px-4 py-2 rounded-full border-2 border-blue-900 shadow hover:bg-[#e6eaf3] transition">Home</a>
            <div class="flex space-x-6 items-center">
                <a href="/user/{{ auth()->id() }}" class="bg-white text-[#0a1931] font-extrabold px-5 py-2 rounded-full shadow hover:bg-[#e6eaf3] border-2 border-[#0a1931] transition">My Profile</a>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button class="text-red-300 hover:text-red-500 font-semibold">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="max-w-4xl mx-auto px-2">
    @yield('content')
</div>

</body>
</html>
