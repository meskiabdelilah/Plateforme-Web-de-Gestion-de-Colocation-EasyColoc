<nav x-data="{ open: false }" class="bg-[#1a1a1a] border-b border-gray-800 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 group">
                        <span class="text-2xl font-bold text-white tracking-tighter transition-all group-hover:scale-105">
                            Easy<span class="text-[#7d2020]">Coloc</span>
                        </span>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-12 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-gray-400 hover:text-white border-transparent hover:border-[#7d2020] transition-all duration-300">
                        <i class="fas fa-th-large me-2 text-xs"></i> {{ __('Dashboard') }}
                    </x-nav-link>

                    @php
                    $colocation = request()->route('colocation') ?? auth()->user()->memberships()->first()?->colocation;
                    @endphp

                    @if($colocation)
                    <x-nav-link :href="route('expenses.index', $colocation)" :active="request()->routeIs('expenses.*')"
                        class="text-gray-400 hover:text-white border-transparent hover:border-[#7d2020] transition-all duration-300">
                        <i class="fas fa-wallet me-2 text-xs"></i> {{ __('Expenses') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-3 px-4 py-2 rounded-full bg-[#2d2d2d] border border-gray-700 text-sm font-medium text-gray-300 hover:text-white hover:bg-[#333333] focus:outline-none transition duration-150 ease-in-out shadow-sm">
                                <div class="w-8 h-8 rounded-full bg-[#7d2020] flex items-center justify-center text-white font-bold text-xs shadow-inner">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div>{{ Auth::user()->name }}</div>
                                <svg class="fill-current h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-[#2d2d2d] border border-gray-700 rounded-xl overflow-hidden shadow-2xl">
                                <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:bg-[#3d3d3d] hover:text-white">
                                    <i class="fas fa-user-circle me-2"></i> {{ __('Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" class="text-red-400 hover:bg-red-500/10 hover:text-red-500 font-semibold"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-white hover:bg-[#2d2d2d] focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#2d2d2d] border-t border-gray-800 animate-fade-in-down">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="rounded-xl text-gray-300 hover:bg-[#1a1a1a] hover:text-[#7d2020]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-800">
            <div class="px-6 flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-[#7d2020] flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl text-gray-400">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="rounded-xl text-red-500 font-bold"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>