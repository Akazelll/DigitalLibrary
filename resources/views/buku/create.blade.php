<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Tambah Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- PENTING: Tambahkan enctype untuk upload file --}}
                    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Input Judul Buku --}}
                        <div>
                            <x-input-label for="judul_buku" value="Judul Buku" />
                            <x-text-input id="judul_buku" name="judul_buku" type="text" class="mt-1 block w-full"
                                :value="old('judul_buku')" required />
                            <x-input-error :messages="$errors->get('judul_buku')" class="mt-2" />
                        </div>

                        {{-- Dropdown Penerbit --}}
                        <div>
                            <x-input-label for="id_penerbit" value="Penerbit" />
                            <select id="id_penerbit" name="id_penerbit"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">- Pilih Penerbit -</option>
                                @foreach ($penerbit as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('id_penerbit') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_penerbit }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_penerbit')" class="mt-2" />
                        </div>

                        {{-- Input Tahun Terbit --}}
                        <div>
                            <x-input-label for="tahun_terbit" value="Tahun Terbit" />
                            <x-text-input id="tahun_terbit" name="tahun_terbit" type="number" class="mt-1 block w-full"
                                :value="old('tahun_terbit')" placeholder="YYYY" required />
                            <x-input-error :messages="$errors->get('tahun_terbit')" class="mt-2" />
                        </div>

                        {{-- Input Jumlah Halaman --}}
                        <div>
                            <x-input-label for="jml_halaman" value="Jumlah Halaman" />
                            <x-text-input id="jml_halaman" name="jml_halaman" type="number" class="mt-1 block w-full"
                                :value="old('jml_halaman')" required />
                            <x-input-error :messages="$errors->get('jml_halaman')" class="mt-2" />
                        </div>

                        {{-- Input Stok Buku --}}
                        <div>
                            <x-input-label for="stok" value="Stok Buku" />
                            <x-text-input id="stok" name="stok" type="number" class="mt-1 block w-full"
                                :value="old('stok', 0)" required />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kategori_id" value="Kategori" />
                            <select id="kategori_id" name="kategori_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">- Pilih Kategori -</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                        </div>

                        {{-- =============================================== --}}
                        {{-- === BARU: Input untuk Upload Gambar Sampul === --}}
                        {{-- =============================================== --}}
                        <div>
                            <x-input-label for="sampul" value="Gambar Sampul (Opsional)" />
                            <input id="sampul" name="sampul" type="file"
                                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, WEBP (MAX. 2MB)</p>
                            <x-input-error :messages="$errors->get('sampul')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-x-4 pt-6">
                            <a href="{{ route('buku.index') }}"
                                class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300">Batal</a>
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
