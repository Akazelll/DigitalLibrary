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

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Aktivitas Peminjaman
                            Anda</h2>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">Berikut adalah daftar semua buku yang
                            sedang dan pernah Anda pinjam.</p>
                    </div>

                    {{-- ======================================================= --}}
                    {{-- === TAMPILAN BARU: LINIMASA PEMINJAMAN (RESPONSIF) === --}}
                    {{-- ======================================================= --}}
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @forelse ($peminjaman as $item)
                                <li>
                                    <div class="relative pb-8">
                                        {{-- Garis vertikal linimasa, tidak ditampilkan untuk item terakhir --}}
                                        @if (!$loop->last)
                                            <span
                                                class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700"
                                                aria-hidden="true"></span>
                                        @endif

                                        <div class="relative flex items-start space-x-3">
                                            <div>
                                                {{-- Ikon Status --}}
                                                <div class="relative px-1">
                                                    <div
                                                        class="h-10 w-10 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-gray-800
                                                        @if ($item->is_overdue) bg-red-500 @elseif($item->status == 'pinjam') bg-yellow-500 @else bg-green-500 @endif">

                                                        @if ($item->is_overdue)
                                                            {{-- Ikon Jam (Terlambat) --}}
                                                            <svg class="h-5 w-5 text-white"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        @elseif($item->status == 'pinjam')
                                                            {{-- Ikon Panah Keluar (Dipinjam) --}}
                                                            <svg class="h-5 w-5 text-white"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.28a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        @else
                                                            {{-- Ikon Centang (Kembali) --}}
                                                            <svg class="h-5 w-5 text-white"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1 py-1.5">
                                                <div class="text-sm text-gray-500">
                                                    <span
                                                        class="font-medium text-gray-900 dark:text-white">{{ $item->buku?->judul_buku ?? 'Buku Telah Dihapus' }}</span>

                                                    {{-- Tampilkan Status --}}
                                                    @if ($item->is_overdue)
                                                        <span class="font-medium text-red-500">(Terlambat)</span>
                                                    @elseif($item->status == 'pinjam')
                                                        <span class="font-medium text-yellow-500">(Sedang
                                                            Dipinjam)</span>
                                                    @else
                                                        <span class="font-medium text-green-500">(Sudah Kembali)</span>
                                                    @endif
                                                </div>
                                                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400 space-y-1">
                                                    <p><strong>Tgl. Pinjam:</strong>
                                                        {{ \Carbon\Carbon::parse($item->tgl_pinjam)->isoFormat('D MMMM Y') }}
                                                    </p>
                                                    <p><strong>Batas Waktu:</strong>
                                                        {{ \Carbon\Carbon::parse($item->tanggal_harus_kembali)->isoFormat('D MMMM Y') }}
                                                    </p>
                                                    @if ($item->tgl_kembali)
                                                        <p><strong>Tgl. Kembali:</strong>
                                                            {{ \Carbon\Carbon::parse($item->tgl_kembali)->isoFormat('D MMMM Y') }}
                                                        </p>
                                                    @endif
                                                    <p><strong>Denda:</strong> <span class="font-semibold">Rp
                                                            {{ number_format($item->denda_terhitung, 0, ',', '.') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li>
                                    <div class="relative flex items-center space-x-3">
                                        <p class="text-sm text-gray-500">Anda belum memiliki riwayat peminjaman.</p>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="mt-6">
                        {{ $peminjaman->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
