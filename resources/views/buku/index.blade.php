<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-main dark:text-dark-text-main leading-tight">
            {{ __('Koleksi Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Header dengan Form Pencarian dan Tombol Tambah --}}
                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-text-main dark:text-dark-text-main">Koleksi
                                Buku</h2>
                            <p class="mt-1 text-sm text-text-subtle dark:text-dark-text-subtle">Telusuri semua buku yang
                                tersedia di perpustakaan.</p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex items-center gap-4">
                            <form action="{{ route('buku.index') }}" method="GET">
                                <div class="flex rounded-md shadow-sm">
                                    {{-- PERUBAHAN PADA SEARCH BAR --}}
                                    <input type="text" name="search" id="search"
                                        class="block w-full min-w-0 flex-1 rounded-none rounded-l-md border-0 py-1.5 text-text-main bg-white dark:bg-dark-surface ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-text-subtle dark:placeholder:text-dark-text-subtle focus:ring-2 focus:ring-inset focus:ring-primary  sm:text-sm sm:leading-6"
                                        placeholder="Cari buku atau penerbit..." value="{{ request('search') }}">
                                    <button type="submit"
                                        class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-text-subtle dark:text-dark-text-subtle bg-gray-50  ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-100 dark:hover:bg-opacity-80">Cari</button>
                                </div>
                            </form>
                            @if (Auth::user()->role == 'admin')
                                <a href="{{ route('buku.create') }}"
                                    class="block rounded-md bg-primary px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">Tambah
                                    Buku</a>
                                <a href="{{ route('buku.download') }}" target="_blank"
                                    class="inline-flex items-center gap-x-2 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 transition-colors duration-200">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v4.59L7.3 9.7a.75.75 0 00-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1V6.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Download
                                </a>
                            @endif
                        </div>
                    </div>

                    @if (session()->has('success'))
                        <div class="mb-4 rounded-md bg-green-50 dark:bg-green-500/10 p-4">
                            <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}
                            </p>
                        </div>
                    @endif

                    {{-- Tampilan Grid Kartu Buku (Responsif) --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-x-6 gap-y-8">
                        @forelse ($buku as $item)
                            <div
                                class="relative flex flex-col bg-base dark:bg-dark-surface rounded-lg shadow p-4 transition-transform duration-300 hover:-translate-y-1">
                                {{-- Gambar Sampul --}}
                                <a href="{{ route('buku.show', $item) }}" class="block">
                                    <div
                                        class="aspect-[2/3] w-full overflow-hidden rounded-md bg-gray-200 dark:bg-dark-primary mb-4">
                                        @if ($item->sampul)
                                            <img src="{{ asset('storage/' . $item->sampul) }}"
                                                alt="Sampul {{ $item->judul_buku }}"
                                                class="h-full w-full object-cover object-center">
                                        @else
                                            <div
                                                class="h-full w-full flex items-center justify-center text-gray-400 dark:text-dark-text-subtle">
                                                <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                {{-- Detail Buku --}}
                                <div class="flex flex-col flex-1">
                                    <h3
                                        class="text-sm font-semibold text-text-main dark:text-dark-text-main leading-tight">
                                        <a href="{{ route('buku.show', $item) }}">{{ $item->judul_buku }}</a>
                                    </h3>
                                    <p class="mt-1 text-sm text-text-subtle dark:text-dark-text-subtle truncate">
                                        {{ $item->penerbit->nama_penerbit }}</p>
                                    @if (Auth::user()->role == 'admin')
                                        <p class="mt-1 text-xs font-mono text-text-subtle dark:text-dark-text-subtle">
                                            ID: {{ $item->kode_buku }}</p>
                                    @endif
                                    <div
                                        class="mt-2 flex justify-between text-xs text-text-subtle dark:text-dark-text-subtle">
                                        <span>Tahun: {{ $item->tahun_terbit }}</span>
                                        <span>{{ $item->jml_halaman }} hal.</span>
                                    </div>
                                    <p class="mt-2 text-sm font-bold text-primary dark:text-highlight">Stok:
                                        {{ $item->stok }}</p>

                                    {{-- Tombol Aksi untuk Admin --}}
                                    @if (Auth::user()->role == 'admin')
                                        <div
                                            class="mt-auto pt-4 flex items-center gap-2 border-t border-gray-200 dark:border-dark-primary mt-4">
                                            <a href="{{ route('buku.edit', $item) }}"
                                                class="flex-1 text-center rounded-md bg-success px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition-colors">Edit</a>
                                            <form action="{{ route('buku.destroy', $item->id) }}" method="POST"
                                                id="delete-form-buku-{{ $item->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="showAlert({{ $item->id }}, 'buku')"
                                                    class="w-full rounded-md bg-danger px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">Hapus</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-text-subtle dark:text-dark-text-subtle py-10">
                                <p>Tidak ada buku yang ditemukan.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-6">
                        {{ $buku->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showAlert(id, module) {
                const isDarkMode = document.documentElement.classList.contains('dark');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',

                    // Terapkan warna dinamis berdasarkan palet tema baru Anda
                    background: isDarkMode ? '#1A1A1A' : '#ffffff', // dark-surface
                    color: isDarkMode ? '#EDEDED' : '#111827', // dark-text-main

                    showCancelButton: true,
                    confirmButtonColor: '#e11d48', // danger
                    cancelButtonColor: '#6b7280', // text-subtle
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
