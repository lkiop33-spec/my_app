<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Primary Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.*')">
                        간단 게시판
                    </x-nav-link>
                    <x-nav-link :href="route('geades.index')" :active="request()->routeIs('geades.*')">
                        직급 관리
                    </x-nav-link>
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        사용자 관리
                    </x-nav-link>
                    <x-nav-link :href="route('departments.index')" :active="request()->routeIs('departments.*')">
                        부서 관리
                    </x-nav-link>
                    <x-nav-link :href="route('notices.index')" :active="request()->routeIs('notices.*')">
                        공지사항
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-400 bg-gray-800 hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-400 hover:bg-gray-900 focus:outline-none focus:bg-gray-900 focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Secondary Navigation Menu (13 English DB Tables) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-gray-700 bg-gray-900/50 hidden sm:block">
        <div class="flex h-12">
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex w-full justify-between overflow-x-auto">
                <x-nav-link :href="route('locations.index')" :active="request()->routeIs('locations.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">Locations</x-nav-link>
                <x-nav-link :href="route('parts.index')" :active="request()->routeIs('parts.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">Parts</x-nav-link>
                <x-nav-link :href="route('levels.index')" :active="request()->routeIs('levels.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">Levels</x-nav-link>
                <x-nav-link :href="route('work_lists.index')" :active="request()->routeIs('work_lists.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">Work Lists</x-nav-link>
                <x-nav-link :href="route('pcb_tables.index')" :active="request()->routeIs('pcb_tables.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">PCB Tables</x-nav-link>
                <x-nav-link :href="route('part_tables.index')" :active="request()->routeIs('part_tables.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">Part Tables</x-nav-link>
                <x-nav-link :href="route('process_tables.index')" :active="request()->routeIs('process_tables.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">Process Tables</x-nav-link>
                <x-nav-link :href="route('pcb_image_tables.index')" :active="request()->routeIs('pcb_image_tables.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">PCB Images</x-nav-link>
                <x-nav-link :href="route('doc_lists.index')" :active="request()->routeIs('doc_lists.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">Doc Lists</x-nav-link>
                <x-nav-link :href="route('types.index')" :active="request()->routeIs('types.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">Types</x-nav-link>
                <x-nav-link :href="route('languages.index')" :active="request()->routeIs('languages.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">Languages</x-nav-link>
                <x-nav-link :href="route('forbiddens.index')" :active="request()->routeIs('forbiddens.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">Forbiddens</x-nav-link>
                <x-nav-link :href="route('devices.index')" :active="request()->routeIs('devices.*')" class="text-xs text-gray-400 border-b-0" style="padding-top: 0;">Devices</x-nav-link>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.*')">
                간단 게시판
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('locations.index')" :active="request()->routeIs('locations.*')">Locations</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('parts.index')" :active="request()->routeIs('parts.*')">Parts</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('levels.index')" :active="request()->routeIs('levels.*')">Levels</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('work_lists.index')" :active="request()->routeIs('work_lists.*')">Work Lists</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pcb_tables.index')" :active="request()->routeIs('pcb_tables.*')">PCB Tables</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('part_tables.index')" :active="request()->routeIs('part_tables.*')">Part Tables</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('process_tables.index')" :active="request()->routeIs('process_tables.*')">Process Tables</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pcb_image_tables.index')" :active="request()->routeIs('pcb_image_tables.*')">PCB Images</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('doc_lists.index')" :active="request()->routeIs('doc_lists.*')">Doc Lists</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('types.index')" :active="request()->routeIs('types.*')">Types</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('languages.index')" :active="request()->routeIs('languages.*')">Languages</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('forbiddens.index')" :active="request()->routeIs('forbiddens.*')">Forbiddens</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('devices.index')" :active="request()->routeIs('devices.*')">Devices</x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
