<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-main leading-tight">
            {{ __('Edit Pengguna: ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Form untuk Informasi Profil --}}
            <div class="p-4 sm:p-8 bg-surface shadow-sm sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-text-main">Informasi Profil</h2>
                        <p class="mt-1 text-sm text-text-subtle">Perbarui informasi profil dan alamat email pengguna.</p>
                    </header>
                    <form method="post" action="{{ route('users.update', $user) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

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

            {{-- Form untuk Reset Password --}}
            <div class="p-4 sm:p-8 bg-surface shadow-sm sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-text-main">Reset Password</h2>
                        <p class="mt-1 text-sm text-text-subtle">Buat password baru untuk pengguna ini. Biarkan kosong
                            jika tidak ingin mengubahnya.</p>
                    </header>
                    <form method="post" action="{{ route('users.update', $user) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

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
</x-app-layout>
