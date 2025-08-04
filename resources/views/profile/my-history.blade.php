<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-main leading-tight">
            {{ __('Riwayat Peminjaman Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold leading-6 text-text-main">Aktivitas Peminjaman Anda</h2>
                        <p class="mt-1 text-sm text-text-subtle">Berikut adalah daftar semua buku yang sedang dan pernah
                            Anda pinjam.</p>
                    </div>

                    {{-- PERUBAHAN DI SINI: Menggunakan space-y untuk memberi jarak antar kartu --}}
                    <div class="space-y-4">
                        @forelse ($peminjaman as $item)
                            {{-- Setiap transaksi dibungkus dalam div dengan border --}}
                            <div
                                class="bg-base rounded-lg shadow-sm p-4 border border-gray-200 flex items-start space-x-4">

                                {{-- Ikon Status --}}
                                <div
                                    class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center
                                    @if ($item->is_overdue) bg-danger @elseif($item->status == 'pinjam') bg-warning @else bg-success @endif">

                                    @if ($item->is_overdue)
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @elseif($item->status == 'pinjam')
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.28a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>

                                {{-- Detail Peminjaman --}}
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm">
                                        <span
                                            class="font-medium text-text-main">{{ $item->buku?->judul_buku ?? 'Buku Telah Dihapus' }}</span>
                                        @if ($item->is_overdue)
                                            <span class="font-medium text-danger">(Terlambat)</span>
                                        @elseif($item->status == 'pinjam')
                                            <span class="font-medium text-warning">(Sedang Dipinjam)</span>
                                        @else
                                            <span class="font-medium text-success">(Sudah Kembali)</span>
                                        @endif
                                    </div>
                                    <div class="mt-2 text-xs text-text-subtle space-y-1">
                                        <p><strong>Tgl. Pinjam:</strong>
                                            {{ \Carbon\Carbon::parse($item->tgl_pinjam)->isoFormat('D MMMM Y') }}</p>
                                        <p><strong>Batas Waktu:</strong>
                                            {{ \Carbon\Carbon::parse($item->tanggal_harus_kembali)->isoFormat('D MMMM Y') }}
                                        </p>
                                        @if ($item->tgl_kembali)
                                            <p><strong>Tgl. Kembali:</strong>
                                                {{ \Carbon\Carbon::parse($item->tgl_kembali)->isoFormat('D MMMM Y') }}
                                            </p>
                                        @endif
                                        <p><strong>Denda:</strong> <span class="font-semibold">Rp
                                                {{ number_format($item->denda_terhitung, 0, ',', '.') }}</span></p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-text-subtle py-10">
                                <p>Anda belum memiliki riwayat peminjaman.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $peminjaman->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
