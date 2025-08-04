<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Peminjaman Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ======================================================= --}}
            {{-- === BAGIAN 1: FORM PENCARIAN ANGGOTA === --}}
            {{-- ======================================================= --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Langkah 1: Cari Anggota
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">Masukkan kode anggota untuk menemukan peminjam.</p>

                    <form action="{{ route('peminjaman.create') }}" method="GET"
                        class="mt-4 sm:flex sm:items-start sm:gap-4">
                        <div>
                            <x-input-label for="kode_anggota" value="Kode Anggota" />
                            <x-text-input id="kode_anggota" name="kode_anggota" type="text"
                                class="mt-1 block w-full sm:w-auto" :value="request('kode_anggota')" required autofocus />
                            <x-input-error :messages="$errors->get('kode_anggota')" class="mt-2" />
                        </div>
                        <x-primary-button class="mt-4 sm:mt-7">Cari Anggota</x-primary-button>
                    </form>
                </div>
            </div>

            {{-- ======================================================================= --}}
            {{-- === BAGIAN 2: FORM PEMINJAMAN (HANYA MUNCUL JIKA ANGGOTA DITEMUKAN) === --}}
            {{-- ======================================================================= --}}
            @if (isset($user) && $user)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Langkah 2: Cari &
                            Tambah Buku</h3>

                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-900/50 rounded-lg">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Nama Peminjam: <span
                                    class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</span></p>
                            <p class="mt-1 text-sm font-medium text-gray-700 dark:text-gray-300">Kode Anggota: <span
                                    class="font-semibold text-gray-900 dark:text-white">{{ $user->kode_anggota }}</span>
                            </p>
                        </div>

                        {{-- Form Cari Buku --}}
                        <form action="{{ route('peminjaman.create') }}" method="GET"
                            class="mt-6 sm:flex sm:items-start sm:gap-4">
                            <input type="hidden" name="kode_anggota" value="{{ $user->kode_anggota }}">
                            <div>
                                <x-input-label for="kode_buku" value="Kode Buku" />
                                <x-text-input id="kode_buku" name="kode_buku" type="text"
                                    class="mt-1 block w-full sm:w-auto" :value="request('kode_buku')" required />
                                <x-input-error :messages="$errors->get('kode_buku')" class="mt-2" />
                            </div>
                            <x-primary-button class="mt-4 sm:mt-7">Cari Buku</x-primary-button>
                        </form>

                        {{-- Form Submit Peminjaman (HANYA MUNCUL JIKA BUKU DITEMUKAN) --}}
                        @if (isset($buku) && $buku)
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="p-4 bg-green-100 dark:bg-green-900/50 rounded-lg">
                                    <p class="font-semibold text-green-800 dark:text-green-200">Buku Ditemukan:</p>
                                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Judul: <span
                                            class="font-semibold text-gray-900 dark:text-white">{{ $buku->judul_buku }}</span>
                                    </p>
                                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Stok Tersedia: <span
                                            class="font-semibold text-gray-900 dark:text-white">{{ $buku->stok }}</span>
                                    </p>
                                </div>
                                <form action="{{ route('peminjaman.store') }}" method="POST" class="mt-6 space-y-6">
                                    @csrf
                                    <input type="hidden" name="id_user" value="{{ $user->id }}">
                                    <input type="hidden" name="id_buku" value="{{ $buku->id }}">
                                    <div>
                                        <x-input-label for="tgl_pinjam" value="Tanggal Pinjam" />
                                        <x-text-input id="tgl_pinjam" name="tgl_pinjam" type="date"
                                            class="mt-1 block w-full" :value="old('tgl_pinjam', date('Y-m-d'))" required />
                                        <x-input-error :messages="$errors->get('tgl_pinjam')" class="mt-2" />
                                    </div>
                                    <div class="flex items-center justify-end gap-x-4 pt-6">
                                        <a href="{{ route('peminjaman.index') }}"
                                            class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300">Batal</a>
                                        <x-primary-button>{{ __('Simpan Peminjaman') }}</x-primary-button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
