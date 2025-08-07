<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-text-main dark:text-dark-text-main">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-text-subtle dark:text-dark-text-subtle">
            {{ __('Setelah akun Anda dihapus, semua datanya akan dihapus permanen. Sebelum menghapus, unduh data apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Hapus Akun') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-surface dark:bg-dark-surface">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-text-main dark:text-dark-text-main">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
            </h2>

            <p class="mt-1 text-sm text-text-subtle dark:text-dark-text-subtle">
                {{ __('Masukkan password Anda untuk mengonfirmasi penghapusan akun secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password_modal_delete" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input id="password_modal_delete" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
