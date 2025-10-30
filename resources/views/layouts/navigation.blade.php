<nav
    x-cloak
    class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 transform transition-transform duration-200 -translate-x-full lg:translate-x-0"
    :class="{ 'translate-x-0': sidebarOpen }"
>
    <!-- Header / Logo -->
    <div class="h-16 px-4 flex items-center border-b border-gray-200">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            <span class="font-semibold text-gray-800">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </div>

    <!-- Links -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        {{-- Dashboard --}}
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="w-full">
            {{ __('Dashboard') }}
        </x-nav-link>

    </div>


    <!-- Dropdown -->
    <div class="border-t border-gray-200 p-3">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="w-full inline-flex items-center justify-between gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none transition">
                    <div class="truncate text-left">
                        <div class="font-medium truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                    </div>
                    <svg class="shrink-0 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
