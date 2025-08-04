<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-main leading-tight">
            {{ __('Edit Data Penerbit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">

                    <form action="{{ route('penerbit.update', $penerbit->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nama_penerbit" value="Nama Penerbit" />
                            <x-text-input id="nama_penerbit" name="nama_penerbit" type="text"
                                class="mt-1 block w-full" :value="old('nama_penerbit', $penerbit->nama_penerbit)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_penerbit')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-x-4 pt-4">
                            <a href="{{ route('penerbit.index') }}"
                                class="text-sm font-semibold leading-6 text-text-subtle hover:text-text-main">Batal</a>
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
