<x-guest-layout>

    <!-- Container -->
    <div class="w-full max-w-sm mx-auto bg-white px-6 py-8 rounded-2xl shadow-lg border border-blue-900/10">

        <!-- Logo + Title -->
        <div class="flex flex-col items-center mb-5">
            <img src="/twitterlogo.png"
                 class="w-8 h-8 object-contain transition-transform duration-500 hover:rotate-6 hover:scale-105 drop-shadow-md">

            <h1 class="text-xl font-semibold text-blue-900 mt-2 tracking-tight">
                Create your account
            </h1>

            <p class="text-slate-500 text-xs mt-1">
                Join Twitter ni Rodwin today
            </p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <x-input-label for="name" :value="__('Name')" class="text-sm" />
                <x-text-input id="name"
                              class="block mt-1 w-full rounded-xl text-sm border-blue-900/30 focus:border-blue-900 focus:ring-blue-900"
                              type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
            </div>

            <!-- Email -->
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" class="text-sm" />
                <x-text-input id="email"
                              class="block mt-1 w-full rounded-xl text-sm border-blue-900/30 focus:border-blue-900 focus:ring-blue-900"
                              type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="password" :value="__('Password')" class="text-sm" />
                <x-text-input id="password"
                              class="block mt-1 w-full rounded-xl text-sm border-blue-900/30 focus:border-blue-900 focus:ring-blue-900"
                              type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-5">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm" />
                <x-text-input id="password_confirmation"
                              class="block mt-1 w-full rounded-xl text-sm border-blue-900/30 focus:border-blue-900 focus:ring-blue-900"
                              type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">

                <!-- Login Link -->
                <a href="{{ route('login') }}"
                   class="text-xs text-blue-900/70 hover:text-blue-900 underline">
                    Already registered?
                </a>

                <!-- Register Button with Effects -->
                <!-- Register Button -->
<button type="submit"
        class="w-full py-2 text-sm font-semibold bg-blue-100 text-blue-900 
               border border-blue-900 rounded-full shadow
               hover:bg-blue-900 hover:text-white hover:shadow-lg
               transition-all duration-300">
    Register
</button>


            </div>

        </form>

    </div>

</x-guest-layout>
