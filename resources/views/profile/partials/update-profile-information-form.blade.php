<section>
    <header>
        <h2 class="text-lg font-medium text-text-main dark:text-dark-text-main">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-text-subtle dark:text-dark-text-subtle">
            {{ __('Perbarui informasi profil dan alamat email akun Anda.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="kode_anggota" :value="__('Kode Anggota')" />
            <x-text-input id="kode_anggota" name="kode_anggota" type="text"
                class="mt-1 block w-full bg-base dark:bg-dark-primary/50 border-gray-200 dark:border-dark-primary"
                :value="$user->kode_anggota" disabled />
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
        </div>
    </form>
</section>
