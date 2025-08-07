<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-main dark:text-dark-text-main leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-text-main dark:text-dark-text-main">Daftar
                                Anggota</h2>
                            <p class="mt-1 text-sm text-text-subtle dark:text-dark-text-subtle">Kelola semua data anggota
                                yang terdaftar di perpustakaan.</p>
                        </div>
                        @if (Auth::user()->role == 'admin')
                            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                <a href="{{ route('users.download') }}" target="_blank"
                                    class="inline-flex items-center gap-x-2 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 transition-colors duration-200">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v4.59L7.3 9.7a.75.75 0 00-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1V6.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Download
                                </a>
                            </div>
                        @endif
                    </div>

                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-50 dark:bg-green-500/10 p-4">
                            <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}
                            </p>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-red-50 dark:bg-red-500/10 p-4">
                            <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ $errors->first() }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($users as $user)
                            <div class="group bg-base dark:bg-dark-base rounded-lg shadow-sm p-6 flex flex-col">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0">
                                            <span
                                                class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-highlight dark:bg-dark-highlight text-primary dark:text-dark-text-main">
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-lg font-semibold text-text-main dark:text-dark-text-main truncate"
                                                title="{{ $user->name }}">
                                                {{ $user->name }}
                                            </p>
                                            <p class="text-sm text-text-subtle dark:text-dark-text-subtle truncate"
                                                title="{{ $user->email }}">
                                                {{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <dl class="mt-4 grid grid-cols-2 gap-4">
                                        {{-- PERBAIKAN DI DUA DIV DI BAWAH INI --}}
                                        <div class="flex flex-col rounded-lg bg-surface dark:bg-dark-surface px-4 py-3">
                                            <dt class="text-sm font-medium text-text-subtle dark:text-dark-text-subtle">
                                                Kode Anggota
                                            </dt>
                                            <dd
                                                class="mt-1 text-lg font-semibold tracking-tight text-text-main dark:text-dark-text-main">
                                                {{ $user->kode_anggota }}
                                            </dd>
                                        </div>
                                        <div class="flex flex-col rounded-lg bg-surface dark:bg-dark-surface px-4 py-3">
                                            <dt class="text-sm font-medium text-text-subtle dark:text-dark-text-subtle">
                                                Total Pinjam
                                            </dt>
                                            <dd
                                                class="mt-1 text-lg font-semibold tracking-tight text-text-main dark:text-dark-text-main">
                                                {{ $user->peminjaman_count }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>

                                <div
                                    class="mt-4 pt-4 flex items-center gap-2 border-t border-gray-200 dark:border-dark-primary">
                                    <a href="{{ route('users.edit', $user) }}"
                                        class="flex-1 text-center rounded-md bg-success px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition-colors">Edit</a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                        id="delete-form-user-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="showAlert({{ $user->id }}, 'user')"
                                            class="w-full rounded-md bg-danger px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-text-subtle dark:text-dark-text-subtle py-10">
                                <p>Data anggota belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showAlert(id, module) {
                const isDarkMode = document.documentElement.classList.contains('dark');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    background: isDarkMode ? '#1A1A1A' : '#ffffff',
                    color: isDarkMode ? '#EDEDED' : '#111827',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${module}-${id}`).submit();
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
