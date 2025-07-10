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

                    <form action="{{ route('buku.update', $buku->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="judul_buku" class="block text-sm font-medium">Judul Buku</label>
                            <div class="mt-1">
                                <input type="text" name="judul_buku" id="judul_buku"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm"
                                    value="{{ old('judul_buku', $buku->judul_buku) }}">
                            </div>
                            @error('judul_buku')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="id_penerbit" class="block text-sm font-medium">Penerbit</label>
                            <div class="mt-1">
                                <select id="id_penerbit" name="id_penerbit"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm">
                                    <option value="">- Pilih Penerbit -</option>
                                    @foreach ($penerbit as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('id_penerbit', $buku->id_penerbit) == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_penerbit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('id_penerbit')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tahun_terbit" class="block text-sm font-medium">Tahun Terbit</label>
                            <div class="mt-1">
                                <input type="number" name="tahun_terbit" id="tahun_terbit" placeholder="YYYY"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm"
                                    value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                            </div>
                            @error('tahun_terbit')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jml_halaman" class="block text-sm font-medium">Jumlah Halaman</label>
                            <div class="mt-1">
                                <input type="number" name="jml_halaman" id="jml_halaman"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm"
                                    value="{{ old('jml_halaman', $buku->jml_halaman) }}">
                            </div>
                            @error('jml_halaman')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ================= PERUBAHAN DI SINI ================= --}}
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
                        {{-- ======================================================= --}}

                        <div class="flex items-center justify-end gap-x-4 pt-6">
                            <a href="{{ route('buku.index') }}" class="text-sm font-semibold leading-6">Batal</a>
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
