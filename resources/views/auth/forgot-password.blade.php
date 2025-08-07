<x-guest-layout>
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
    </div>

    <div class="mb-4 text-sm text-text-subtle dark:text-dark-text-subtle text-center">
        {{ __('Lupa password Anda? Tidak masalah. Cukup beritahu kami alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password baru.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-6">
            <x-primary-button class="w-full flex justify-center">
                {{ __('Kirim Tautan Reset Password') }}
            </x-primary-button>

            <a href="{{ route('login') }}"
                class="mt-4 underline text-sm text-text-subtle dark:text-dark-text-subtle hover:text-text-main dark:hover:text-dark-text-main">
                Kembali ke Login
            </a>
        </div>
    </form>
</x-guest-layout>
