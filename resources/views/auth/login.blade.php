<x-guest-layout>

    <!-- Container -->
    <div class="w-full max-w-md mx-auto bg-white px-8 py-10 rounded-3xl shadow-xl border border-blue-900/20">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-6">
            <img src="/twitterlogo.png"
                 class="w-16 h-16 object-contain transition-transform duration-500 hover:rotate-6 hover:scale-105 drop-shadow-md">

            <h1 class="text-2xl font-bold text-blue-900 mt-3 tracking-tight">
                Welcome Back
            </h1>

            <p class="text-slate-600 text-sm">
                Log in to continue the conversation.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email"
                              class="block mt-1 w-full rounded-xl border-blue-900/30 focus:border-blue-900 focus:ring-blue-900"
                              type="email"
                              name="email"
                              :value="old('email')"
                              required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password"
                              class="block mt-1 w-full rounded-xl border-blue-900/30 focus:border-blue-900 focus:ring-blue-900"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-4">
                <input id="remember_me" type="checkbox"
                       class="rounded border-blue-900/40 text-blue-900 shadow-sm focus:ring-blue-900"
                       name="remember">

                <label for="remember_me" class="ms-2 text-sm text-gray-600">
                    {{ __('Remember me') }}
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-blue-900/70 hover:text-blue-900 underline">
                        {{ __('Forgot password?') }}
                    </a>
                @endif

                <!-- Log in Button -->
                <button type="submit"
                        class="px-6 py-2 font-semibold bg-white text-blue-900 border-2 border-blue-900 rounded-full shadow
                               hover:bg-blue-900 hover:text-white hover:border-transparent
                               hover:shadow-[0_8px_20px_rgba(0,115,255,0.35)]
                               hover:-translate-y-[3px] hover:scale-[1.05]
                               transition-all duration-300">
                    Log in
                </button>

            </div>

        </form>

        <!-- Divider spacing -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}"
                   class="font-semibold text-blue-900 hover:underline hover:text-blue-700">
                    Register
                </a>
            </p>
        </div>

    </div>

</x-guest-layout>
