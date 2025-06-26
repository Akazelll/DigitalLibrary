<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Selamat Datang Universal --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">{{ $greeting }}, {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        @if (Auth::user()->role == 'admin')
                            Berikut adalah ringkasan data dari aplikasi perpustakaan Anda.
                        @else
                            Selamat datang di DigiPustaka. Cari dan pinjam buku favoritmu!
                        @endif
                    </p>
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- ============ TAMPILAN KHUSUS UNTUK ADMIN ============ --}}
            {{-- ========================================================= --}}
            @if (Auth::user()->role == 'admin')

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    {{-- Card Total Buku --}}
                    <a href="{{ route('buku.index') }}"
                        class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        {{-- ... (Isi card buku seperti sebelumnya) ... --}}
                    </a>
                    {{-- Card Total Penerbit --}}
                    <a href="{{ route('penerbit.index') }}"
                        class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        {{-- ... (Isi card penerbit seperti sebelumnya) ... --}}
                    </a>
                    {{-- Card Peminjaman Aktif --}}
                    <a href="{{ route('peminjaman.index') }}"
                        class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        {{-- ... (Isi card peminjaman seperti sebelumnya) ... --}}
                    </a>
                    {{-- Card Total Pengguna --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        {{-- ... (Isi card pengguna seperti sebelumnya) ... --}}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    {{-- ... (Isi panel aktivitas terbaru seperti sebelumnya) ... --}}
                </div>

                {{-- ========================================================= --}}
                {{-- ============ TAMPILAN KHUSUS UNTUK USER BIASA ============ --}}
                {{-- ========================================================= --}}
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">Cari
                                    Koleksi Buku</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Temukan buku favoritmu di
                                    antara ribuan koleksi kami.</p>
                                <form action="{{ route('buku.index') }}" method="GET"
                                    class="mt-4 flex rounded-md shadow-sm">
                                    <input type="text" name="search"
                                        class="block w-full flex-1 rounded-none rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 dark:bg-gray-700 dark:text-white"
                                        placeholder="Ketik judul buku...">
                                    <button type="submit"
                                        class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Cari</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">Riwayat
                                    Peminjaman Anda</h3>
                                <div class="mt-4 space-y-4">
                                    @forelse ($peminjamanUser as $peminjaman)
                                        <div
                                            class="border-l-4 @if ($peminjaman->status == 'pinjam') border-yellow-400 @else border-green-400 @endif pl-4">
                                            <p class="font-semibold text-sm text-gray-800 dark:text-gray-200">
                                                {{ $peminjaman->buku->judul_buku }}</p>
                                            <p class="text-xs text-gray-500">Dipinjam:
                                                {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->isoFormat('D MMM Y') }}
                                            </p>
                                            @if ($peminjaman->tgl_kembali)
                                                <p class="text-xs text-gray-500">Dikembalikan:
                                                    {{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->isoFormat('D MMM Y') }}
                                                </p>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500">Anda belum pernah meminjam buku.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
