<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-main dark:text-dark-text-main leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-text-main dark:text-dark-text-main">
                    <h3 class="text-lg font-medium">{{ $greeting }}, {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-sm text-text-subtle dark:text-dark-text-subtle">
                        @if (Auth::user()->role == 'admin')
                            Berikut adalah ringkasan dan analitik dari aplikasi perpustakaan Anda.
                        @else
                            Selamat datang di DigiPustaka. Lacak aktivitas peminjaman dan temukan buku favoritmu!
                        @endif
                    </p>
                </div>
            </div>
            <br>
            @if (Auth::user()->role == 'admin')

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                    {{-- Card Total Buku --}}
                    <a href="{{ route('buku.index') }}"
                        class="group block p-6 bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-primary rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt
                                        class="text-sm font-medium text-text-subtle dark:text-dark-text-subtle truncate">
                                        Total Buku</dt>
                                    <dd>
                                        <div class="text-3xl font-semibold text-text-main dark:text-dark-text-main">
                                            {{ $totalBuku }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </a>

                    {{-- Card Total Penerbit --}}
                    <a href="{{ route('penerbit.index') }}"
                        class="group block p-6 bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-success rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt
                                        class="text-sm font-medium text-text-subtle dark:text-dark-text-subtle truncate">
                                        Total Penerbit</dt>
                                    <dd>
                                        <div class="text-3xl font-semibold text-text-main dark:text-dark-text-main">
                                            {{ $totalPenerbit }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </a>

                    {{-- Card Peminjaman Aktif --}}
                    <a href="{{ route('peminjaman.index') }}"
                        class="group block p-6 bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-warning rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h12M3.75 3.75h16.5M3.75 12h16.5m-16.5 4.5h16.5" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt
                                        class="text-sm font-medium text-text-subtle dark:text-dark-text-subtle truncate">
                                        Peminjaman Aktif</dt>
                                    <dd>
                                        <div class="text-3xl font-semibold text-text-main dark:text-dark-text-main">
                                            {{ $peminjamanAktif }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </a>

                    {{-- Card Total Pengguna --}}
                    <div class="p-6 bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-danger rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-2.308M15 19.128v-3.043m0 3.043-2.625-.372a9.337 9.337 0 0 1-4.121-2.308m10.468-2.115a9.337 9.337 0 0 1-2.308-4.121m0 0-2.308-4.121a9.337 9.337 0 0 0-4.121-2.308m10.468 2.115a9.337 9.337 0 0 0-2.308-4.121m0 0a9.337 9.337 0 0 0-4.121-2.308m-2.308 10.468a9.337 9.337 0 0 1 2.308 4.121m0 0a9.337 9.337 0 0 1 4.121 2.308" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt
                                        class="text-sm font-medium text-text-subtle dark:text-dark-text-subtle truncate">
                                        Total Pengguna</dt>
                                    <dd>
                                        <div class="text-3xl font-semibold text-text-main dark:text-dark-text-main">
                                            {{ $totalUser }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-base font-semibold leading-6 text-text-main dark:text-dark-text-main">Tren
                                Peminjaman</h3>
                            <p class="mt-1 text-sm text-text-subtle dark:text-dark-text-subtle">Jumlah buku yang
                                dipinjam dalam 6 bulan terakhir.</p>
                            <div class="mt-6 h-80">
                                <canvas id="loanChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-base font-semibold leading-6 text-text-main dark:text-dark-text-main">
                                    Buku Terpopuler</h3>
                                <ul role="list" class="mt-4 divide-y divide-gray-200 dark:divide-dark-primary">
                                    @forelse ($bukuPopuler as $buku)
                                        <li class="py-3 flex">
                                            <div class="flex-1 min-w-0">
                                                <p
                                                    class="text-sm font-medium text-text-main dark:text-dark-text-main truncate">
                                                    {{ $buku->judul_buku }}</p>
                                                <p class="text-sm text-text-subtle dark:text-dark-text-subtle truncate">
                                                    {{ $buku->penerbit->nama_penerbit }}</p>
                                            </div>
                                            <div class="text-sm text-text-main dark:text-dark-text-main">
                                                {{ $buku->peminjaman_count }}x dipinjam</div>
                                        </li>
                                    @empty
                                        <li class="py-3 text-sm text-text-subtle dark:text-dark-text-subtle">Belum ada
                                            data peminjaman.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        <div class="bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-base font-semibold leading-6 text-text-main dark:text-dark-text-main">
                                    Anggota Teraktif</h3>
                                <ul role="list" class="mt-4 divide-y divide-gray-200 dark:divide-dark-primary">
                                    @forelse ($anggotaAktif as $user)
                                        <li class="py-3 flex">
                                            <div class="flex-1 min-w-0">
                                                <p
                                                    class="text-sm font-medium text-text-main dark:text-dark-text-main truncate">
                                                    {{ $user->name }}</p>
                                                <p class="text-sm text-text-subtle dark:text-dark-text-subtle truncate">
                                                    {{ $user->email }}</p>
                                            </div>
                                            <div class="text-sm text-text-main dark:text-dark-text-main">
                                                {{ $user->peminjaman_count }}x meminjam</div>
                                        </li>
                                    @empty
                                        <li class="py-3 text-sm text-text-subtle dark:text-dark-text-subtle">Belum ada
                                            data peminjaman.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ============ TAMPILAN KHUSUS UNTUK USER BIASA ============ --}}
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-base font-semibold leading-6 text-text-main dark:text-dark-text-main">
                                    Buku
                                    yang Sedang Anda Pinjam</h3>
                                <div class="mt-4 space-y-4">
                                    @forelse ($sedangDipinjam as $peminjaman)
                                        <div
                                            class="border-l-4 @if ($peminjaman->is_overdue) border-danger @else border-warning @endif pl-4 py-2">
                                            <p class="font-semibold text-sm text-text-main dark:text-dark-text-main">
                                                {{ $peminjaman->buku?->judul_buku ?? 'Buku Telah Dihapus' }}</p>
                                            <p class="text-xs text-text-subtle dark:text-dark-text-subtle">Batas Waktu:
                                                <span
                                                    class="font-medium">{{ \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->isoFormat('D MMMM Y') }}</span>
                                            </p>
                                            @if ($peminjaman->is_overdue)
                                                <p class="text-xs font-bold text-danger">Sudah Terlambat!</p>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-sm text-text-subtle dark:text-dark-text-subtle">Anda sedang
                                            tidak meminjam buku.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-base font-semibold leading-6 text-text-main dark:text-dark-text-main">
                                    Buku
                                    Paling Populer</h3>
                                <p class="mt-1 text-sm text-text-subtle dark:text-dark-text-subtle">Lihat koleksi yang
                                    paling
                                    disukai pengguna lain.</p>
                                <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                    @foreach ($bukuPopuler as $buku)
                                        <a href="{{ route('buku.show', $buku) }}" class="group">
                                            <div
                                                class="aspect-[2/3] w-full overflow-hidden rounded-lg bg-gray-200 dark:bg-dark-primary">
                                                @if ($buku->sampul)
                                                    <img src="{{ asset('storage/' . $buku->sampul) }}" alt="Sampul"
                                                        class="h-full w-full object-cover object-center">
                                                @else
                                                    <div
                                                        class="h-full w-full flex items-center justify-center text-gray-400 dark:text-dark-text-subtle">
                                                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <h4
                                                class="mt-2 text-xs font-medium text-text-main dark:text-dark-text-main truncate">
                                                {{ $buku->judul_buku }}</h4>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-base font-semibold leading-6 text-text-main dark:text-dark-text-main">
                                    Statistik Anda</h3>
                                <dl class="mt-4 space-y-4">
                                    <div class="flex flex-col rounded-lg bg-base dark:bg-dark-primary px-4 py-3">
                                        <dt class="text-sm font-medium text-text-subtle dark:text-dark-text-subtle">
                                            Total Buku
                                            Dibaca</dt>
                                        <dd
                                            class="mt-1 text-2xl font-semibold tracking-tight text-text-main dark:text-dark-text-main">
                                            {{ $totalDibaca }}</dd>
                                    </div>
                                    <div class="flex flex-col rounded-lg bg-base dark:bg-dark-primary px-4 py-3">
                                        <dt class="text-sm font-medium text-text-subtle dark:text-dark-text-subtle">
                                            Total Denda
                                        </dt>
                                        <dd
                                            class="mt-1 text-2xl font-semibold tracking-tight text-text-main dark:text-dark-text-main">
                                            Rp {{ number_format($totalDenda, 0, ',', '.') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        <div class="bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <a href="{{ route('profile.history') }}"
                                    class="group flex items-center justify-between">
                                    <span
                                        class="text-base font-semibold leading-6 text-text-main dark:text-dark-text-main">Lihat
                                        Semua Riwayat</span>
                                    <span
                                        class="text-primary dark:text-highlight group-hover:translate-x-1 transition-transform duration-200">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    @push('scripts')
        @if (Auth::user()->role == 'admin')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const ctx = document.getElementById('loanChart').getContext('2d');

                    window.myLoanChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($loanChartLabels) !!},
                            datasets: [{
                                label: 'Jumlah Peminjaman',
                                data: {!! json_encode($loanChartData) !!},
                                borderWidth: 2,
                                borderRadius: 5,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    barPercentage: 0.5,
                                    categoryPercentage: 0.8
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    displayColors: false,
                                    callbacks: {
                                        label: (context) => `${context.raw} Peminjaman`
                                    }
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            }
                        }
                    });

                    window.updateChartTheme = function() {
                        if (!window.myLoanChart) return;
                        const isDarkMode = document.documentElement.classList.contains('dark');
                        const chart = window.myLoanChart;
                        const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
                        const tickColor = isDarkMode ? '#C8ACD6' : '#6b7280';
                        const barColors = isDarkMode ?
                            ['rgba(67, 56, 202, 0.8)', 'rgba(217, 119, 6, 0.8)', 'rgba(5, 150, 105, 0.8)',
                                'rgba(220, 38, 38, 0.8)', 'rgba(37, 99, 235, 0.8)', 'rgba(124, 58, 237, 0.8)'
                            ] :
                            ['rgba(79, 70, 229, 0.7)', 'rgba(245, 158, 11, 0.7)', 'rgba(16, 185, 129, 0.7)',
                                'rgba(239, 68, 68, 0.7)', 'rgba(59, 130, 246, 0.7)', 'rgba(139, 92, 246, 0.7)'
                            ];
                        const borderColors = barColors.map(color => color.replace(/0\.\d+\)/, '1)'));

                        chart.data.datasets[0].backgroundColor = barColors;
                        chart.data.datasets[0].borderColor = borderColors;
                        chart.options.scales.y.grid.color = gridColor;
                        chart.options.scales.y.ticks.color = tickColor;
                        chart.options.scales.x.ticks.color = tickColor;
                        chart.update();
                    };

                    window.updateChartTheme();
                });
            </script>
        @endif
    @endpush
</x-app-layout>
