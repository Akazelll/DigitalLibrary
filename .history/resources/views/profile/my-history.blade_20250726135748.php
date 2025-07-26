<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Peminjaman Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Daftar Transaksi</h2>
                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">Berikut adalah semua riwayat peminjaman buku
                        Anda.</p>

                    <!-- Tampilan Desktop (TABLE) -->
                    <div class="mt-6 hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-6">No</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Judul Buku</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Tgl Pinjam</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Batas Waktu</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Tgl Kembali</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Denda</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800 bg-white dark:bg-gray-900">
                                @forelse ($peminjaman as $item)
                                    <tr @if ($item->is_overdue) class="bg-red-50 dark:bg-red-900/20" @endif>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-6">
                                            {{ $peminjaman->firstItem() + $loop->index }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            {{ $item->buku?->judul_buku ?? 'Buku Telah Dihapus' }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y') }}</td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-sm font-medium @if ($item->is_overdue) text-red-600 dark:text-red-400 @endif">
                                            {{ \Carbon\Carbon::parse($item->tanggal_harus_kembali)->format('d-m-Y') }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            {{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-semibold">Rp
                                            {{ number_format($item->denda_terhitung, 0, ',', '.') }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            @if ($item->is_overdue)
                                                <span
                                                    class="inline-flex items-center rounded-md bg-red-100 dark:bg-red-900/50 px-2 py-1 text-xs font-medium text-red-700 dark:text-red-300 ring-1 ring-inset ring-red-600/20">Terlambat</span>
                                            @elseif($item->status == 'pinjam')
                                                <span
                                                    class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/50 px-2 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-300 ring-1 ring-inset ring-yellow-600/20">Dipinjam</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/50 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-300 ring-1 ring-inset ring-green-600/20">Kembali</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-3 py-4 text-sm text-center">Anda belum memiliki
                                            riwayat peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $peminjaman->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
