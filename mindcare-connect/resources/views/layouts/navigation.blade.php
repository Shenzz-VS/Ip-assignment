<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                        <!-- Medical Cross / Heart Icon -->
                        <svg class="h-8 w-8 text-teal-600 transition duration-300 group-hover:text-teal-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-3H6v-2h3V9h2v3h3v2h-3v3z"/>
                        </svg>
                        <span class="font-bold text-xl text-slate-800 tracking-tight">MindCare<span class="text-teal-600">Connect</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Admin Links -->
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('User Management') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.audit_logs')" :active="request()->routeIs('admin.audit_logs')">
                            {{ __('Audit Logs') }}
                        </x-nav-link>
                        <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                            {{ __('Messages') }}
                        </x-nav-link>
                    @endif

                    <!-- Counselor Links -->
                    @if(Auth::user()->role === 'counselor')
                        <x-nav-link :href="route('counselor.assessments.index')" :active="request()->routeIs('counselor.assessments.*')">
                            {{ __('Manage Assessments') }}
                        </x-nav-link>
                        <x-nav-link :href="route('counselor.wellness.index')" :active="request()->routeIs('counselor.wellness.*')">
                            {{ __('Wellness Resources') }}
                        </x-nav-link>
                        <x-nav-link :href="route('counselor.schedules.index')" :active="request()->routeIs('counselor.schedules.*')">
                            {{ __('My Schedule') }}
                        </x-nav-link>
                        <x-nav-link :href="route('counselor.appointments.index')" :active="request()->routeIs('counselor.appointments.*')">
                            {{ __('Appointments') }}
                        </x-nav-link>
                        <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                            {{ __('Messages') }}
                        </x-nav-link>
                        <x-nav-link :href="route('counselor.assessments.results')" :active="request()->routeIs('counselor.assessments.results') || request()->routeIs('counselor.assessments.show_result')">
                        {{ __('Patient Results') }}
                        </x-nav-link>
                    @endif

                    <!-- Patient Links -->
                    @if(Auth::user()->role === 'patient')
                        <x-nav-link :href="route('patient.assessments.index')" :active="request()->routeIs('patient.assessments.*')">
                            {{ __('Take Assessments') }}
                        </x-nav-link>
                        <x-nav-link :href="route('patient.appointments.create')" :active="request()->routeIs('patient.appointments.*')">
                            {{ __('Book Appointment') }}
                        </x-nav-link>
                        <x-nav-link :href="route('journals.index')" :active="request()->routeIs('journals.*')">
                            {{ __('My Mood Journal') }}
                        </x-nav-link>
                        <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                            {{ __('Messages') }}
                        </x-nav-link>
                    @endif
                </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center gap-3">
    @if(Auth::user()->profile_photo_path)
        <img class="h-8 w-8 rounded-full object-cover border border-slate-300 shadow-sm" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
    @else
        <!-- Fallback avatar with their first initial -->
        <div class="h-8 w-8 rounded-full bg-teal-600 border border-teal-700 shadow-sm flex items-center justify-center text-white font-bold text-sm">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
    @endif
    <span class="font-medium text-slate-700">{{ Auth::user()->name }}</span>
</div>
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

            <!-- Hamburger (Mobile Menu Toggle) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Admin Links -->
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('User Management') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.audit_logs')" :active="request()->routeIs('admin.audit_logs')">
                    {{ __('Audit Logs') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                    {{ __('Messages') }}
                </x-responsive-nav-link>
            @endif

            <!-- Counselor Links -->
            @if(Auth::user()->role === 'counselor')
                <x-responsive-nav-link :href="route('counselor.assessments.index')" :active="request()->routeIs('counselor.assessments.*')">
                    {{ __('Manage Assessments') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('counselor.wellness.index')" :active="request()->routeIs('counselor.wellness.*')">
                    {{ __('Wellness Resources') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('counselor.schedules.index')" :active="request()->routeIs('counselor.schedules.*')">
                    {{ __('My Schedule') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('counselor.appointments.index')" :active="request()->routeIs('counselor.appointments.*')">
                    {{ __('Appointments') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                    {{ __('Messages') }}
                </x-responsive-nav-link>
            @endif

            <!-- Patient Links -->
            @if(Auth::user()->role === 'patient')
                <x-responsive-nav-link :href="route('patient.assessments.index')" :active="request()->routeIs('patient.assessments.*')">
                    {{ __('Take Assessments') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('patient.appointments.create')" :active="request()->routeIs('patient.appointments.*')">
                    {{ __('Book Appointment') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('journals.index')" :active="request()->routeIs('journals.*')">
                    {{ __('My Mood Journal') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                    {{ __('Messages') }}
                </x-responsive-nav-link>
            @endif
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