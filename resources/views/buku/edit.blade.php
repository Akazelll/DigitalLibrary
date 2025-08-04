<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-main leading-tight">
            {{ __('Edit Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">

                    <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="judul_buku" value="Judul Buku" />
                            <x-text-input id="judul_buku" name="judul_buku" type="text" class="mt-1 block w-full"
                                :value="old('judul_buku', $buku->judul_buku)" required />
                            <x-input-error :messages="$errors->get('judul_buku')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id_penerbit" value="Penerbit" />
                            <select id="id_penerbit" name="id_penerbit"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary text-text-main"
                                required>
                                <option value="">- Pilih Penerbit -</option>
                                @foreach ($penerbit as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('id_penerbit', $buku->id_penerbit) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_penerbit }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_penerbit')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tahun_terbit" value="Tahun Terbit" />
                            <x-text-input id="tahun_terbit" name="tahun_terbit" type="number" class="mt-1 block w-full"
                                :value="old('tahun_terbit', $buku->tahun_terbit)" placeholder="YYYY" required />
                            <x-input-error :messages="$errors->get('tahun_terbit')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="jml_halaman" value="Jumlah Halaman" />
                            <x-text-input id="jml_halaman" name="jml_halaman" type="number" class="mt-1 block w-full"
                                :value="old('jml_halaman', $buku->jml_halaman)" required />
                            <x-input-error :messages="$errors->get('jml_halaman')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="stok" value="Stok Buku" />
                            <x-text-input id="stok" name="stok" type="number" class="mt-1 block w-full"
                                :value="old('stok', $buku->stok ?? 0)" required />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="sampul" value="Ganti Gambar Sampul (Opsional)" />
                            @if ($buku->sampul)
                                <img src="{{ asset('storage/' . $buku->sampul) }}" alt="Sampul saat ini"
                                    class="w-32 h-auto rounded-md mt-2 mb-2 shadow-md">
                            @endif
                            <input id="sampul" name="sampul" type="file"
                                class="mt-1 block w-full text-sm text-text-subtle border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                            <p class="mt-1 text-xs text-text-subtle">Biarkan kosong jika tidak ingin mengganti sampul.
                            </p>
                            <x-input-error :messages="$errors->get('sampul')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-x-4 pt-6">
                            <a href="{{ route('buku.index') }}"
                                class="text-sm font-semibold leading-6 text-text-subtle hover:text-text-main">Batal</a>
                            <x-primary-button>{{ __('Update Buku') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
