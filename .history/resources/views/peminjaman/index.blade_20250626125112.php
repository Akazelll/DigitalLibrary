<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Peminjaman') }}
        </h2>
    </x-slot>

    {{-- Form Cetak Laporan --}}
    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-base font-semibold leading-6">Cetak Laporan Peminjaman</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Pilih rentang tanggal untuk mencetak laporan
                        dalam format PDF.</p>
                    <form action="{{ route('laporan.peminjaman.cetak') }}" method="GET" target="_blank"
                        class="mt-4 sm:flex sm:items-end sm:gap-4">
                        <div>
                            <label for="tanggal_awal" class="block text-sm font-medium">Tanggal Awal</label>
                            <div class="mt-1">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" required
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm sm:text-sm"
                                    value="{{ date('Y-m-01') }}">
                            </div>
                        </div>
                        <div>
                            <label for="tanggal_akhir" class="block text-sm font-medium">Tanggal Akhir</label>
                            <div class="mt-1">
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" required
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm sm:text-sm"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                class="rounded-md bg-cyan-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-cyan-500">
                                <svg class="inline-block h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 2.5a2.5 2.5 0 0 1 5 0V5h5a1.5 1.5 0 0 1 1.5 1.5v8.5a1.5 1.5 0 0 1-1.5 1.5H3.5A1.5 1.5 0 0 1 2 15V6.5A1.5 1.5 0 0 1 3.5 5H5V2.5ZM10 4V2.5A1.5 1.5 0 0 0 8.5 1h-2A1.5 1.5 0 0 0 5 2.5V4h5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Cetak PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Konten Utama --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <p class="text-sm text-gray-700 dark:text-gray-300">Daftar semua transaksi peminjaman buku.
                            </p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a href="{{ route('peminjaman.create') }}"
                                class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Tambah
                                Peminjaman</a>
                        </div>
                    </div>

                    @if (session()->has('success'))
                        <div class="mb-4 rounded-md bg-green-100 dark:bg-green-800 p-4">
                            <p class="text-sm font-medium text-green-700 dark:text-green-200">{{ session('success') }}
                            </p>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200 sm:pl-6">
                                        No</th>
                                    <th
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                                        Peminjam</th>
                                    <th
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                                        Judul Buku</th>
                                    <th
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                                        Tgl Pinjam</th>
                                    <th
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                                        Tgl Kembali</th>
                                    <th
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">
                                        Status</th>
                                    <th
                                        class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right text-sm font-semibold text-gray-900 dark:text-gray-200">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @forelse ($peminjaman as $item)
                                    <tr>
                                        {{-- ================= PERUBAHAN 1: PENOMORAN ================= --}}
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-6">
                                            {{ $peminjaman->firstItem() + $loop->index }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $item->user->name }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $item->buku->judul_buku }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y') }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            {{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            @if ($item->status == 'pinjam')
                                                <span
                                                    class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Dipinjam</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Kembali</span>
                                            @endif
                                        </td>
                                        <td
                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            @if ($item->status == 'pinjam')
                                                <a href="{{ route('peminjaman.edit', $item->id) }}"
                                                    class="rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                                                    onclick="event.preventDefault(); showReturnAlert(this.href);">Kembalikan</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-3 py-4 text-sm text-center">Data peminjaman belum
                                            tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- ================= PERUBAHAN 2: LINK PAGINATION ================= --}}
                    <div class="mt-6">
                        {{ $peminjaman->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT SWEET ALERT --}}
    @push('scripts')
        <script>
            function showReturnAlert(url) {
                const isDarkMode = document.documentElement.classList.contains('dark');
                Swal.fire({
                    title: 'Konfirmasi Pengembalian',
                    text: "Apakah Anda yakin buku ini sudah dikembalikan?",
                    icon: 'question',
                    background: isDarkMode ? '#1f2937' : '#fff',
                    color: isDarkMode ? '#d1d5db' : '#111827',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, sudah!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
