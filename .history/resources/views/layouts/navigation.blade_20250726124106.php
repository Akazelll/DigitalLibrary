<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <svg class="h-8 w-auto text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                        <span
                            class="font-semibold text-xl text-gray-900 dark:text-white">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @auth
                        {{-- Menu untuk semua user yang login --}}
                        <x-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.*')">
                            {{ __('Buku') }}
                        </x-nav-link>
                        <x-nav-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')">
                            {{ __('Kategori') }}
                        </x-nav-link>

                        {{-- Menu khusus admin --}}
                        @if (Auth::user()->role == 'admin')
                            <x-nav-link :href="route('penerbit.index')" :active="request()->routeIs('penerbit.*')">
                                {{ __('Penerbit') }}
                            </x-nav-link>
                            <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.*')">
                                {{ __('Peminjaman') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown & Theme Switcher -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <!-- ======================================================= -->
                <!-- === BARU: Tombol Switcher Tema (Desktop) === -->
                <!-- ======================================================= -->
                <div x-data="themeSwitcher" class="mr-4 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                <svg x-show="theme === 'light'" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                                </svg>
                                <svg x-show="theme === 'dark'" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                                </svg>
                                <svg x-show="theme === 'system'" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-1.621-.87a3 3 0 0 1-.879-2.122v-1.007M15 15.75a3 3 0 0 0-3-3m0 0a3 3 0 0 0-3 3m3-3V11.25m6-4.75a3 3 0 0 0-3-3H9a3 3 0 0 0-3 3v4.5a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3v-4.5Z" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="#" @click.prevent="applyTheme('light')">Light</x-dropdown-link>
                            <x-dropdown-link href="#" @click.prevent="applyTheme('dark')">Dark</x-dropdown-link>
                            <x-dropdown-link href="#"
                                @click.prevent="applyTheme('system')">System</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- User Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg></div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.*')">
                    {{ __('Buku') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')">
                    {{ __('Kategori') }}
                </x-responsive-nav-link>

                @if (Auth::user()->role == 'admin')
                    <x-responsive-nav-link :href="route('penerbit.index')" :active="request()->routeIs('penerbit.*')">
                        {{ __('Penerbit') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.*')">
                        {{ __('Peminjaman') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- ======================================================= -->
                <!-- === BARU: Pilihan Tema (Mobile) === -->
                <!-- ======================================================= -->
                <div x-data="themeSwitcher" class="border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                    <div class="px-4 text-xs text-gray-500 dark:text-gray-400 mb-1">Tema</div>
                    <x-responsive-nav-link href="#"
                        @click.prevent="applyTheme('light')">Light</x-responsive-nav-link>
                    <x-responsive-nav-link href="#"
                        @click.prevent="applyTheme('dark')">Dark</x-responsive-nav-link>
                    <x-responsive-nav-link href="#"
                        @click.prevent="applyTheme('system')">System</x-responsive-nav-link>
                </div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
