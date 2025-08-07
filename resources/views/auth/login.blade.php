<x-guest-layout>
    <!-- Logo -->
    <div class="flex flex-col items-center mb-6">
        <a href="/" class="flex items-center gap-2">
            <svg class="h-10 w-auto text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
            <span
                class="font-semibold text-2xl text-text-main dark:text-dark-text-main">{{ config('app.name', 'Laravel') }}</span>
        </a>
        <p class="mt-2 text-sm text-text-subtle dark:text-dark-text-subtle">Selamat datang kembali! Silakan login.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 dark:border-gray-700 dark:bg-dark-surface text-primary dark:text-dark-primary shadow-sm focus:ring-primary dark:focus:ring-dark-primary"
                    name="remember">
                <span class="ms-2 text-sm text-text-subtle dark:text-dark-text-subtle">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-text-subtle dark:text-dark-text-subtle hover:text-text-main dark:hover:text-dark-text-main rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                    href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="flex flex-col items-center justify-end mt-6">
            <x-primary-button class="w-full flex justify-center">
                {{ __('Log in') }}
            </x-primary-button>

            <p class="mt-4 text-sm text-center text-text-subtle dark:text-dark-text-subtle">
                Belum punya akun?
                <a href="{{ route('register') }}"
                    class="underline text-primary dark:text-dark-primary hover:text-opacity-80">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
