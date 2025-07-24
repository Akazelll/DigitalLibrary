<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Edit Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- ... (Semua input lain seperti judul, penerbit, dll.) ... --}}

                        {{-- Input Stok Buku --}}
                        <div>
                            <label for="stok" class="block text-sm font-medium">Stok Buku</label>
                            <div class="mt-1">
                                <input type="number" name="stok" id="stok"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm"
                                    value="{{ old('stok', $buku->stok ?? 0) }}" required>
                            </div>
                            @error('stok')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- =============================================== --}}
                        {{-- === BARU: Input untuk Upload Gambar Sampul === --}}
                        {{-- =============================================== --}}
                        <div>
                            <x-input-label for="sampul" value="Ganti Gambar Sampul (Opsional)" />
                            @if ($buku->sampul)
                                <img src="{{ asset('storage/' . $buku->sampul) }}" alt="Sampul saat ini"
                                    class="w-32 h-auto rounded-md mt-2 mb-2 shadow-md">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin
                                    mengganti sampul.</p>
                            @endif
                            <input id="sampul" name="sampul" type="file"
                                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <x-input-error :messages="$errors->get('sampul')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-x-4 pt-6">
                            <a href="{{ route('buku.index') }}"
                                class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300">Batal</a>
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
