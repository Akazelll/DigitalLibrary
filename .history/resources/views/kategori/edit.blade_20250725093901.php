<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="nama_kategori" value="Nama Kategori" />
                            <x-text-input id="nama_kategori" name="nama_kategori" type="text"
                                class="mt-1 block w-full" :value="old('nama_kategori', $kategori->nama_kategori)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_kategori')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end gap-x-4 pt-6">
                            <a href="{{ route('kategori.index') }}"
                                class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300">Batal</a>
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
