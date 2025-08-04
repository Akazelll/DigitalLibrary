<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pengguna: ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Form untuk Informasi Profil --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informasi Profil</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Perbarui informasi profil dan alamat
                                email pengguna.</p>
                        </header>
                        <form method="post" action="{{ route('users.update', $user) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT') {{-- Gunakan PUT atau PATCH untuk update --}}

                            <div>
                                <x-input-label for="name" :value="__('Nama')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    :value="old('name', $user->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    :value="old('email', $user->email)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            {{-- Form untuk Reset Password --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Reset Password</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Buat password baru untuk pengguna
                                ini. Biarkan kosong jika tidak ingin mengubahnya.</p>
                        </header>
                        <form method="post" action="{{ route('users.update', $user) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT') {{-- Gunakan PUT atau PATCH untuk update --}}

                            <div>
                                <x-input-label for="password" :value="__('Password Baru')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                    autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                    class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Reset Password') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
