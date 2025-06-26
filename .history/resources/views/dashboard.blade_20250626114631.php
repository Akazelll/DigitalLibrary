<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">{{ $greeting }}, {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Berikut adalah ringkasan data dari aplikasi
                        perpustakaan Anda.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                <a href="{{ route('buku.index') }}"
                    class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
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
                    </div>
                </a>

                <a href="{{ route('penerbit.index') }}"
                    class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
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
                    </div>
                </a>

                <a href="{{ route('peminjaman.index') }}"
                    class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h12M3.75 3.75h16.5M3.75 12h16.5m-16.5 4.5h16.5" />
                                </svg>
                            </div>
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
                    </div>
                </a>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-2.308M15 19.128v-3.043m0 3.043-2.625-.372a9.337 9.337 0 0 1-4.121-2.308m10.468-2.115a9.337 9.337 0 0 1-2.308-4.121m0 0-2.308-4.121a9.337 9.337 0 0 0-4.121-2.308m10.468 2.115a9.337 9.337 0 0 0-2.308-4.121m0 0a9.337 9.337 0 0 0-4.121-2.308m-2.308 10.468a9.337 9.337 0 0 1 2.308 4.121m0 0a9.337 9.337 0 0 1 4.121 2.308m-10.468-2.115a9.337 9.337 0 0 0 2.308 4.121m0 0a9.337 9.337 0 0 0 4.121 2.308" />
                                </svg>
                            </div>
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

            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">Aktivitas Peminjaman
                        Terbaru</h3>
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($peminjamanTerbaru as $peminjaman)
                                    <tr>
                                        <td class="py-4 px-3 text-sm">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    {{-- Placeholder untuk avatar --}}
                                                    <span
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-500">
                                                        <span
                                                            class="font-medium leading-none text-white">{{ strtoupper(substr($peminjaman->user->name, 0, 2)) }}</span>
                                                    </span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900 dark:text-white">
                                                        {{ $peminjaman->user->name }}</div>
                                                    <div class="text-gray-500">meminjam <span
                                                            class="font-semibold">{{ $peminjaman->buku->judul_buku }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right">
                                            {{ $peminjaman->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-4 px-3 text-sm text-gray-500">Belum ada aktivitas peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
