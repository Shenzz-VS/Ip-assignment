<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Counselor Workspace') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Clinical Overview Banner -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-8" style="background: linear-gradient(to right, #f0fdfa, #ffffff);">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-teal-900 mb-1">Dr. {{ Auth::user()->name }}</h3>
                        <p class="text-slate-600">Welcome to your clinical dashboard. Here is your overview for today.</p>
                    </div>
                    <div class="hidden sm:block bg-teal-100 p-4 rounded-full">
                        <svg class="h-8 w-8 text-teal-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Action Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Manage Assessments Card -->
            <a href="{{ route('counselor.assessments.index') }}" class="block group">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transition duration-300 hover:shadow-md hover:border-teal-300 h-full">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-blue-50 p-3 rounded-lg group-hover:bg-blue-100 transition">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                        <h4 class="font-bold text-lg text-slate-800">Assessments</h4>
                    </div>
                    <p class="text-slate-500 text-sm">Create, edit, and review patient psychological assessments.</p>
                </div>
            </a>

            <!-- Manage Schedule Card -->
            <a href="{{ route('counselor.schedules.index') }}" class="block group">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transition duration-300 hover:shadow-md hover:border-teal-300 h-full">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-emerald-50 p-3 rounded-lg group-hover:bg-emerald-100 transition">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <h4 class="font-bold text-lg text-slate-800">My Schedule</h4>
                    </div>
                    <p class="text-slate-500 text-sm">Manage your availability, working hours, and time blocks.</p>
                </div>
            </a>

            <!-- Patient Messages Card -->
            <a href="{{ route('messages.index') }}" class="block group">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transition duration-300 hover:shadow-md hover:border-teal-300 h-full">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-purple-50 p-3 rounded-lg group-hover:bg-purple-100 transition">
                            <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                        </div>
                        <h4 class="font-bold text-lg text-slate-800">Secure Inbox</h4>
                    </div>
                    <p class="text-slate-500 text-sm">Respond to patient inquiries and review secure messages.</p>
                </div>
            </a>
            
        </div>
    </div>
</x-app-layout>