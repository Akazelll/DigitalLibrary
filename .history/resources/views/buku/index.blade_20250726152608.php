<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Koleksi Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Koleksi Buku
                            </h2>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">Telusuri semua buku yang tersedia
                                di perpustakaan.</p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex items-center gap-4">
                            <form action="{{ route('buku.index') }}" method="GET">
                                <div class="flex rounded-md shadow-sm">
                                    <input type="text" name="search" id="search"
                                        class="block w-full min-w-0 flex-1 rounded-none rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:text-white dark:ring-gray-600 dark:focus:ring-indigo-500"
                                        placeholder="Cari buku atau penerbit..." value="{{ request('search') }}">
                                    <button type="submit"
                                        class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-gray-600 dark:text-white dark:ring-gray-600 dark:hover:bg-gray-500">Cari</button>
                                </div>
                            </form>
                            @if (Auth::user()->role == 'admin')
                                <a href="{{ route('buku.create') }}"
                                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Tambah
                                    Buku</a>
                            @endif
                        </div>
                    </div>

                    @if (session()->has('success'))
                        <div class="mb-4 rounded-md bg-green-100 dark:bg-green-800 p-4">
                            <p class="text-sm font-medium text-green-700 dark:text-green-200">{{ session('success') }}
                            </p>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-x-6 gap-y-8">
                        @forelse ($buku as $item)
                            <div
                                class="relative flex flex-col bg-gray-50 dark:bg-gray-800/50 rounded-lg shadow p-4 transition-transform duration-300 hover:-translate-y-1">
                                <div
                                    class="aspect-[2/3] w-full overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700 mb-4">
                                    @if ($item->sampul)
                                        <img src="{{ asset('storage/' . $item->sampul) }}"
                                            alt="Sampul {{ $item->judul_buku }}"
                                            class="h-full w-full object-cover object-center">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-col flex-1">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white leading-tight">
                                        {{ $item->judul_buku }}</h3>
                                    <p class="mt-1 text-sm text-gray-500 truncate">{{ $item->penerbit->nama_penerbit }}
                                    </p>

                                    <div class="mt-2 flex justify-between text-xs text-gray-500">
                                        <span>Tahun: {{ $item->tahun_terbit }}</span>
                                        <span>{{ $item->jml_halaman }} hal.</span>
                                    </div>

                                    <p class="mt-2 text-sm font-bold text-indigo-600 dark:text-indigo-400">Stok:
                                        {{ $item->stok }}</p>

                                    @if (Auth::user()->role == 'admin')
                                        <div
                                            class="mt-auto pt-4 flex items-center gap-2 border-t border-gray-200 dark:border-gray-700 mt-4">
                                            <a href="{{ route('buku.edit', $item) }}"
                                                class="flex-1 text-center rounded-md bg-white dark:bg-gray-700 px-2.5 py-1.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-green-600 hover:bg-gray-50 dark:hover:bg-green-600">Edit</a>
                                            <form action="{{ route('buku.destroy', $item->id) }}" method="POST"
                                                id="delete-form-buku-{{ $item->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="showAlert({{ $item->id }}, 'buku')"
                                                    class="rounded-md bg-gray-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-red-600 hover:bg-red-500">Hapus</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500 py-10">
                                <p>Tidak ada buku yang ditemukan.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-6">
                        {{ $buku->appends(request()->query())->links() }}
                    </div>
                    @if (request('kategori'))
                        <div
                            class="mb-4 p-4 bg-indigo-50 dark:bg-indigo-900/50 rounded-lg flex items-center justify-between">
                            <p class="text-sm text-indigo-800 dark:text-indigo-200">
                                Menampilkan buku untuk kategori: <span
                                    class="font-bold">{{ request('kategori') }}</span>
                            </p>
                            <a href="{{ route('buku.index') }}"
                                class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">&times; Hapus
                                Filter</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showAlert(id, module) {
                // 1. Tambahkan deteksi mode gelap
                const isDarkMode = document.documentElement.classList.contains('dark');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',

                    // 2. Terapkan warna latar dan teks dinamis
                    background: isDarkMode ? '#1f2937' : '#fff',
                    color: isDarkMode ? '#d1d5db' : '#111827',

                    showCancelButton: true,

                    // 3. Atur warna tombol (merah untuk konfirmasi hapus)
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6e7881',

                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'

                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${module}-${id}`).submit();
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
