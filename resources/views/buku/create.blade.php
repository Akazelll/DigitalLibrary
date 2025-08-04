<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Buku Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" x-data="bookScanner()">

                    {{-- BAGIAN 1: FITUR TAMBAH CEPAT DENGAN AI --}}
                    <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Tambah Cepat dengan
                            AI</h3>
                        <p class="mt-1 text-sm text-gray-500">Unggah gambar sampul dan biarkan sistem mengisi detailnya
                            secara otomatis di form di bawah ini.</p>

                        <button type="button" @click="$refs.coverInput.click()" :disabled="isLoading"
                            class="mt-4 inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 disabled:bg-indigo-400 disabled:cursor-not-allowed transition-colors duration-200">
                            <svg x-show="!isLoading" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M1.5 6a2.5 2.5 0 012.5-2.5h11.5a2.5 2.5 0 012.5 2.5v7.5a2.5 2.5 0 01-2.5 2.5H4A2.5 2.5 0 011.5 13.5V6zM4 16a1.5 1.5 0 01-1.5-1.5V6A1.5 1.5 0 014 4.5h11.5a1.5 1.5 0 011.5 1.5v7.5a1.5 1.5 0 01-1.5 1.5H4z"
                                    clip-rule="evenodd" />
                                <path d="M6.5 10.5a.5.5 0 000-1h7a.5.5 0 000 1h-7z" />
                                <path d="M10 7.5a.5.5 0 00-1 0v7a.5.5 0 001 0v-7z" />
                            </svg>
                            <svg x-show="isLoading" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span x-text="isLoading ? 'Memindai...' : 'Pindai Sampul Buku'"></span>
                        </button>

                        <input type="file" x-ref="coverInput" @change="handleFileSelect" class="hidden"
                            accept="image/png, image/jpeg, image/webp">

                        <div x-show="errorMessage" x-cloak
                            class="mt-4 p-4 bg-red-100 dark:bg-red-900/50 rounded-lg text-sm text-red-700 dark:text-red-200"
                            x-text="errorMessage"></div>
                    </div>

                    {{-- BAGIAN 2: FORM PENGISIAN MANUAL --}}
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Detail Buku (Manual)
                    </h3>
                    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data"
                        class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="judul_buku" value="Judul Buku" />
                            <x-text-input id="judul_buku" name="judul_buku" type="text" class="mt-1 block w-full"
                                x-model="book.judul_buku" required />
                            <x-input-error :messages="$errors->get('judul_buku')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kategori_id" value="Kategori" />
                            <select id="kategori_id" name="kategori_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">- Pilih Kategori -</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id_penerbit" value="Penerbit" />
                            <select id="id_penerbit" name="id_penerbit"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                required>
                                <option value="">- Pilih Penerbit -</option>
                                @foreach ($penerbit as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_penerbit }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_penerbit')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tahun_terbit" value="Tahun Terbit" />
                            <x-text-input id="tahun_terbit" name="tahun_terbit" type="number" class="mt-1 block w-full"
                                x-model="book.tahun_terbit" placeholder="YYYY" required />
                            <x-input-error :messages="$errors->get('tahun_terbit')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="jml_halaman" value="Jumlah Halaman" />
                            <x-text-input id="jml_halaman" name="jml_halaman" type="number" class="mt-1 block w-full"
                                x-model="book.jml_halaman" required />
                            <x-input-error :messages="$errors->get('jml_halaman')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="stok" value="Stok Buku" />
                            <x-text-input id="stok" name="stok" type="number" class="mt-1 block w-full"
                                :value="old('stok', 1)" required />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="sampul" value="Gambar Sampul (Manual)" />
                            <input id="sampul" name="sampul" type="file"
                                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Gunakan ini jika pemindai AI gagal
                                atau untuk mengunggah gambar spesifik.</p>
                            <x-input-error :messages="$errors->get('sampul')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-x-4 pt-6">
                            <a href="{{ route('buku.index') }}"
                                class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300">Batal</a>
                            <x-primary-button>{{ __('Simpan Buku') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function bookScanner() {
                return {
                    isLoading: false,
                    errorMessage: '',
                    book: {
                        judul_buku: '{{ old('judul_buku') }}',
                        tahun_terbit: '{{ old('tahun_terbit') }}',
                        jml_halaman: '{{ old('jml_halaman') }}',
                    },

                    handleFileSelect(event) {
                        this.isLoading = true;
                        this.errorMessage = '';

                        const file = event.target.files[0];
                        if (!file) {
                            this.isLoading = false;
                            return;
                        }

                        const formData = new FormData();
                        formData.append('cover_image', file);

                        fetch('{{ route('buku.scan') }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                            })
                            .then(async response => {
                                if (!response.ok) {
                                    const errorData = await response.json();
                                    throw new Error(errorData.message || `Error: ${response.statusText}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                this.isLoading = false;
                                this.book.judul_buku = data.judul_buku || '';
                                this.book.tahun_terbit = data.tahun_terbit || '';
                                this.book.jml_halaman = data.jml_halaman || '';
                                this.findAndSelectOption('id_penerbit', data.penerbit);
                            })
                            .catch(error => {
                                this.isLoading = false;
                                this.errorMessage = `Gagal memindai: ${error.message}. Silakan coba lagi atau isi manual.`;
                                console.error('Scan Error:', error);
                            });
                    },

                    findAndSelectOption(selectId, textToFind) {
                        const selectElement = document.getElementById(selectId);
                        if (!selectElement || !textToFind) return;
                        for (let i = 0; i < selectElement.options.length; i++) {
                            if (selectElement.options[i].text.toLowerCase().includes(textToFind.toLowerCase())) {
                                selectElement.selectedIndex = i;
                                break;
                            }
                        }
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
