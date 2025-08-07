<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-main dark:text-dark-text-main leading-tight">
            {{ __('Edit Pengguna: ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Form untuk Informasi Profil --}}
            <div class="p-4 sm:p-8 bg-surface dark:bg-dark-surface shadow-sm sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-text-main dark:text-dark-text-main">Informasi Profil</h2>
                        <p class="mt-1 text-sm text-text-subtle dark:text-dark-text-subtle">Perbarui informasi profil dan
                            alamat email pengguna.</p>
                    </header>

                    {{-- Menambahkan onsubmit untuk memanggil SweetAlert --}}
                    <form method="post" action="{{ route('users.update', $user) }}" class="mt-6 space-y-6"
                        onsubmit="confirmUpdate(event, 'profil')">
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
            <div class="p-4 sm:p-8 bg-surface dark:bg-dark-surface shadow-sm sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-text-main dark:text-dark-text-main">Reset Password</h2>
                        <p class="mt-1 text-sm text-text-subtle dark:text-dark-text-subtle">Buat password baru untuk
                            pengguna ini. Biarkan kosong jika tidak ingin mengubahnya.</p>
                    </header>

                    {{-- Menambahkan onsubmit untuk memanggil SweetAlert --}}
                    <form method="post" action="{{ route('users.update', $user) }}" class="mt-6 space-y-6"
                        onsubmit="confirmUpdate(event, 'password')">
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

    @push('scripts')
        <script>
            function confirmUpdate(event, formType) {
                event.preventDefault(); // Mencegah form dikirim secara langsung

                const isDarkMode = document.documentElement.classList.contains('dark');
                let titleText = formType === 'profil' ? 'Konfirmasi Perubahan Profil' : 'Konfirmasi Reset Password';

                Swal.fire({
                    title: titleText,
                    text: "Apakah Anda yakin ingin menyimpan perubahan ini?",
                    icon: 'question',
                    background: isDarkMode ? '#1A1A1A' : '#ffffff',
                    color: isDarkMode ? '#EDEDED' : '#111827',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, kirim form
                        event.target.submit();
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
