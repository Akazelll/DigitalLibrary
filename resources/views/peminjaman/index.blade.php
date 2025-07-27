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
                                class="w-full sm:w-auto rounded-md bg-cyan-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-cyan-500">
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

                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Daftar
                                Transaksi</h2>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">Semua data transaksi peminjaman
                                buku.</p>
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
                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-red-100 dark:bg-red-900/50 p-4">
                            <p class="text-sm font-medium text-red-700 dark:text-red-200">{{ $errors->first() }}</p>
                        </div>
                    @endif

                    {{-- Tampilan Desktop (TABLE) --}}
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-6">No</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Peminjam</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Judul Buku</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Batas Waktu</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Sisa Denda</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Status</th>
                                    <th class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right text-sm font-semibold">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800 bg-white dark:bg-gray-900">
                                @forelse ($peminjaman as $item)
                                    <tr @if ($item->is_overdue) class="bg-red-50 dark:bg-red-900/20" @endif>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-6">
                                            {{ $peminjaman->firstItem() + $loop->index }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $item->user->name }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            {{ $item->buku?->judul_buku ?? 'Buku Telah Dihapus' }}</td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-sm font-medium @if ($item->is_overdue) text-red-600 dark:text-red-400 @endif">
                                            {{ \Carbon\Carbon::parse($item->tanggal_harus_kembali)->format('d-m-Y') }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-semibold">
                                            Rp {{ number_format($item->sisa_denda, 0, ',', '.') }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            @if ($item->is_overdue)
                                                <span
                                                    class="inline-flex items-center rounded-md bg-red-100 dark:bg-red-900/50 px-2 py-1 text-xs font-medium text-red-700 dark:text-red-300 ring-1 ring-inset ring-red-600/20">Terlambat</span>
                                            @elseif($item->status == 'pinjam')
                                                <span
                                                    class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/50 px-2 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-300 ring-1 ring-inset ring-yellow-600/20">Dipinjam</span>
                                            @else
                                                @if ($item->status_denda == 'Belum Lunas')
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-orange-100 dark:bg-orange-900/50 px-2 py-1 text-xs font-medium text-orange-700 dark:text-orange-300 ring-1 ring-inset ring-orange-600/20">Denda
                                                        Belum Lunas</span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/50 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-300 ring-1 ring-inset ring-green-600/20">Lunas</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td
                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 space-x-2">
                                            @if ($item->sisa_denda > 0)
                                                <button type="button"
                                                    onclick="showPaymentModal({{ $item->id }}, {{ $item->sisa_denda }})"
                                                    class="rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500">Bayar
                                                    Denda</button>
                                            @endif
                                            @if ($item->status == 'pinjam')
                                                <a href="{{ route('peminjaman.edit', $item->id) }}"
                                                    class="rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                                                    onclick="event.preventDefault(); showReturnAlert(this.href);">Kembalikan</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-3 py-4 text-sm text-center">Data peminjaman belum
                                            tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Tampilan Mobile (CARDS) --}}
                    <div class="block lg:hidden space-y-4">
                        @forelse ($peminjaman as $item)
                            <div
                                class="bg-gray-50 dark:bg-gray-800/50 rounded-lg shadow p-4 @if ($item->is_overdue) ring-2 ring-red-500 @endif">
                                <div class="flex justify-between items-start">
                                    <div class="font-semibold text-gray-900 dark:text-white">
                                        {{ $item->buku?->judul_buku ?? 'Buku Telah Dihapus' }}</div>
                                    <div>
                                        @if ($item->is_overdue)
                                            <span
                                                class="inline-flex items-center rounded-md bg-red-100 dark:bg-red-900/50 px-2 py-1 text-xs font-medium text-red-700 dark:text-red-300 ring-1 ring-inset ring-red-600/20">Terlambat</span>
                                        @elseif($item->status == 'pinjam')
                                            <span
                                                class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-900/50 px-2 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-300 ring-1 ring-inset ring-yellow-600/20">Dipinjam</span>
                                        @else
                                            @if ($item->status_denda == 'Belum Lunas')
                                                <span
                                                    class="inline-flex items-center rounded-md bg-orange-100 dark:bg-orange-900/50 px-2 py-1 text-xs font-medium text-orange-700 dark:text-orange-300 ring-1 ring-inset ring-orange-600/20">Denda
                                                    Belum Lunas</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/50 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-300 ring-1 ring-inset ring-green-600/20">Lunas</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                    <div class="flex justify-between"><span
                                            class="font-medium text-gray-800 dark:text-gray-300">Peminjam:</span><span>{{ $item->user->name }}</span>
                                    </div>
                                    <div
                                        class="flex justify-between @if ($item->is_overdue) text-red-600 dark:text-red-400 @endif">
                                        <span class="font-medium text-gray-800 dark:text-gray-300">Batas
                                            Waktu:</span><span
                                            class="font-semibold">{{ \Carbon\Carbon::parse($item->tanggal_harus_kembali)->format('d-m-Y') }}</span>
                                    </div>
                                    <div class="flex justify-between"><span
                                            class="font-medium text-gray-800 dark:text-gray-300">Sisa Denda:</span><span
                                            class="font-semibold">Rp
                                            {{ number_format($item->sisa_denda, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div
                                    class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row gap-2">
                                    @if ($item->sisa_denda > 0)
                                        <button type="button"
                                            onclick="showPaymentModal({{ $item->id }}, {{ $item->sisa_denda }})"
                                            class="w-full rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500">Bayar
                                            Denda</button>
                                    @endif
                                    @if ($item->status == 'pinjam')
                                        <a href="{{ route('peminjaman.edit', $item->id) }}"
                                            class="w-full block rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                                            onclick="event.preventDefault(); showReturnAlert(this.href);">Kembalikan</a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-center">Data peminjaman belum tersedia.</p>
                        @endforelse
                    </div>

                    {{-- Form tersembunyi untuk pembayaran --}}
                    <form id="payment-form" action="" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="jumlah_bayar" id="jumlah_bayar_input">
                    </form>

                    <div class="mt-6">
                        {{ $peminjaman->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

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
                    confirmButtonColor: '#2563eb', // Blue-600
                    cancelButtonColor: '#6b7280', // Gray-500
                    confirmButtonText: 'Ya, Kembalikan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                })
            }

            function showPaymentModal(peminjamanId, sisaDenda) {
                const isDarkMode = document.documentElement.classList.contains('dark');

                Swal.fire({
                    title: 'Pembayaran Denda',
                    html: `Sisa denda yang harus dibayar: <strong>Rp ${new Intl.NumberFormat('id-ID').format(sisaDenda)}</strong>`,
                    input: 'number',
                    inputLabel: 'Masukkan jumlah pembayaran',
                    inputPlaceholder: 'Contoh: 5000',
                    showCancelButton: true,
                    confirmButtonText: 'Bayar',
                    cancelButtonText: 'Batal',
                    background: isDarkMode ? '#1f2937' : '#fff',
                    color: isDarkMode ? '#d1d5db' : '#111827',
                    confirmButtonColor: '#16a34a', // Green-600
                    cancelButtonColor: '#6b7280', // Gray-500
                    inputValidator: (value) => {
                        if (!value || value <= 0) {
                            return 'Jumlah pembayaran tidak valid!'
                        }
                        if (parseInt(value) > sisaDenda) {
                            return 'Jumlah pembayaran melebihi sisa denda!'
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('payment-form');
                        const amountInput = document.getElementById('jumlah_bayar_input');

                        form.action = `/peminjaman/${peminjamanId}/bayar-denda`;
                        amountInput.value = result.value;

                        form.submit();
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
