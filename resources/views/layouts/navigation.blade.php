<nav x-data="{ open: false }">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('planning.index')" :active="request()->routeIs('planning.index')">
                        {{ __('messages.planning') }}
                    </x-nav-link>
                    <x-nav-link :href="route('billing.index')" :active="request()->routeIs('billing.index')">
                        {{ __('messages.billing') }}
                    </x-nav-link>
                    <x-nav-link :href="route('school.index')" :active="request()->routeIs('school.index')">
                        {{ __('messages.schools') }}
                    </x-nav-link>
                    <x-nav-link :href="route('program.index')" :active="request()->routeIs('program.index')">
                        {{ __('messages.programs') }}
                    </x-nav-link>
                    <x-nav-link :href="route('group.index')" :active="request()->routeIs('group.index')">
                        {{ __('messages.groups') }}
                    </x-nav-link>
                    <x-nav-link :href="route('bill.index')" :active="request()->routeIs('bill.index')">
                        {{ __('messages.bills') }}
                    </x-nav-link>
                <!-- Edit switch -->
                <div class='inline-flex items-center px-1 pt-1'>
                    <div class="toggle-container edit toggled-once">
                    @if(Auth::user()->getMode() == "Edit")
                        <input class="toggle-checkbox toggled-once" type="checkbox" id="edit-toggle" checked>
                    @else
                        <input class="toggle-checkbox" type="checkbox" id="edit-toggle">
                    @endif
                    {{Auth::user()->getMode() }}
                        <div class="toggle-track">  
                            <div class="toggle-thumb"></div>
                        </div>
                    </div>
                </div>
                <script>
                const checkbox = document.getElementById('edit-toggle');

                const detectToggleOnce = (e) => {
                    e.target.classList.add('toggled-once');
                    let url = "{{ route('profile.switch') }}";
                    document.location.href=url;
                };

                checkbox.addEventListener('click', detectToggleOnce, { once: true });

                </script>
                @php
                    $current_year = session('current_year');
                    $current_semester = session('current_semester');
                    $years = session('years');
                @endphp
                <!-- Period selector -->
            <form class="nav-form" action="{{route('date.select')}}" method="post">
                @csrf
                <select id="current_year" name="current_year" onchange="this.form.submit()">
                    <option value="all" @if($current_year == "all")selected @endif>{{ __('actions.select_all')}}</option>
                    @isset($years)
                    @foreach ($years as $year)
                    <option value="{{$year->year}}" @if($current_year == $year->year)selected @endif>{{$year->year}}</option>
                    @endforeach                                        
                    @endisset
                </select>
            </form>
                    <!-- Link to admin (Filament) -->
                    @if(Auth::user()->getStatusName() == 'admin')
                    <x-nav-link :href="route('filament.admin.pages.dashboard')" :active="request()->routeIs('filament.admin.pages.dashboard')">
                    {{ __('Admin') }}
                    </x-nav-link>
                    @endif
                </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }} ({{Auth::user()->getStatusName()}})</div>

                            <div class="ml-1">
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
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ Auth::user()->getCompany()->name }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
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
