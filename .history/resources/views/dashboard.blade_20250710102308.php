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

            {{-- ============================================= --}}
            {{-- ============ TAMPILAN KHUSUS ADMIN ============ --}}
            {{-- ============================================= --}}
            @if (Auth::user()->role == 'admin')

                <!-- Stat Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    {{-- Card Total Buku --}}
                    <a href="{{ route('buku.index') }}"
                        class="group block p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3"><svg class="h-6 w-6 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                </svg></div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Buku
                                    </dt>
                                    <dd>
                                        <div class="text-3xl font-semibold text-gray-900 dark:text-gray-200">
                                            {{ $totalBuku }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </a>
                    {{-- Card Total Penerbit --}}
                    <a href="{{ route('penerbit.index') }}"
                        class="group block p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3"><svg class="h-6 w-6 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg></div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total
                                        Penerbit</dt>
                                    <dd>
                                        <div class="text-3xl font-semibold text-gray-900 dark:text-gray-200">
                                            {{ $totalPenerbit }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </a>
                    {{-- Card Peminjaman Aktif --}}
                    <a href="{{ route('peminjaman.index') }}"
                        class="group block p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3"><svg class="h-6 w-6 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h12M3.75 3.75h16.5M3.75 12h16.5m-16.5 4.5h16.5" />
                                </svg></div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Peminjaman
                                        Aktif</dt>
                                    <dd>
                                        <div class="text-3xl font-semibold text-gray-900 dark:text-gray-200">
                                            {{ $peminjamanAktif }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </a>
                    {{-- Card Total Pengguna --}}
                    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3"><svg class="h-6 w-6 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-2.308M15 19.128v-3.043m0 3.043-2.625-.372a9.337 9.337 0 0 1-4.121-2.308m10.468-2.115a9.337 9.337 0 0 1-2.308-4.121m0 0-2.308-4.121a9.337 9.337 0 0 0-4.121-2.308m10.468 2.115a9.337 9.337 0 0 0-2.308-4.121m0 0a9.337 9.337 0 0 0-4.121-2.308m-2.308 10.468a9.337 9.337 0 0 1 2.308 4.121m0 0a9.337 9.337 0 0 1 4.121 2.308m-10.468-2.115a9.337 9.337 0 0 0 2.308 4.121m0 0a9.337 9.337 0 0 0 4.121 2.308" />
                                </svg></div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total
                                        Pengguna</dt>
                                    <dd>
                                        <div class="text-3xl font-semibold text-gray-900 dark:text-gray-200">
                                            {{ $totalUser }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Panel Aktivitas Terbaru (Kolom Kiri) -->
                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">Aktivitas
                                Peminjaman Terbaru</h3>
                            <div class="mt-4 flow-root">
                                <ul role="list" class="-mb-8">
                                    @forelse ($peminjamanTerbaru as $peminjaman)
                                        <li>
                                            <div class="relative pb-8">
                                                @if (!$loop->last)
                                                    <span
                                                        class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700"
                                                        aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex items-center space-x-3">
                                                    <div>
                                                        <span
                                                            class="h-10 w-10 rounded-full bg-gray-400 dark:bg-gray-600 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                            <svg class="h-5 w-5 text-white"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-sm text-gray-500">
                                                            <span
                                                                class="font-medium text-gray-900 dark:text-white">{{ $peminjaman->user->name }}</span>
                                                            meminjam buku <span
                                                                class="font-medium text-gray-900 dark:text-white">{{ $peminjaman->buku?->judul_buku ?? '[Buku Telah Dihapus]' }}</span>
                                                        </p>
                                                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                            {{ $peminjaman->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li>
                                            <p class="text-sm text-gray-500">Belum ada aktivitas peminjaman.</p>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Statistik Buku (Kolom Kanan) -->
                    <div class="lg:col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">Statistik
                                Penambahan Buku</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">6 Bulan Terakhir</p>
                            <div class="mt-6">
                                <canvas id="bookChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ======================================================== --}}
                {{-- ============ TAMPILAN KHUSUS UNTUK USER BIASA ============ --}}
                {{-- ======================================================== --}}
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
                                            class="border-l-4 @if ($peminjaman->status == 'pinjam') border-yellow-400 @else border-green-400 @endif pl-4 py-1">
                                            <p class="font-semibold text-sm text-gray-800 dark:text-gray-200">
                                                {{ $peminjaman->buku?->judul_buku ?? 'Buku Telah Dihapus' }}</p>
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

    @push('scripts')
        {{-- Script hanya akan dimuat jika yang login adalah admin --}}
        @if (Auth::user()->role == 'admin')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('bookChart');
                const isDarkMode = document.documentElement.classList.contains('dark');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! $chartLabels !!},
                        datasets: [{
                            label: 'Buku Baru',
                            data: {!! $chartData !!},
                            backgroundColor: 'rgba(79, 70, 229, 0.8)',
                            borderColor: 'rgba(79, 70, 229, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: isDarkMode ? '#9ca3af' : '#6b7280',
                                    precision: 0
                                },
                                grid: {
                                    color: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                }
                            },
                            x: {
                                ticks: {
                                    color: isDarkMode ? '#9ca3af' : '#6b7280'
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            </script>
        @endif
    @endpush
</x-app-layout>
