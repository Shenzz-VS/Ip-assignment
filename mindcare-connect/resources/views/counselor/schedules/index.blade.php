<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Manage My Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Alerts -->
        @if (session('status'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded shadow-sm mb-6">
                <p class="font-bold">Success</p>
                <p>{{ session('status') }}</p>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded shadow-sm mb-6">
                <p class="font-bold">Error</p>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Left Column: Add New Slot Form -->
            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Add Available Time</h3>
                    <form action="{{ route('counselor.schedules.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Date</label>
                                <input type="date" name="available_date" required min="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Start Time</label>
                                <input type="time" name="start_window" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">End Time</label>
                                <input type="time" name="end_window" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>
                            
                            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-black font-bold py-2 px-4 rounded-lg shadow-sm transition">
                                Open Time Slot
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Current Schedule -->
            <div class="md:col-span-2">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">My Upcoming Slots</h3>
                    
                    @if($schedules->isEmpty())
                        <p class="text-slate-500 text-center py-8 bg-slate-50 rounded-lg">You have no upcoming availability. Add time slots using the form to let patients book appointments.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($schedules as $schedule)
                                <div class="flex items-center justify-between p-4 rounded-lg border {{ $schedule->is_booked ? 'bg-blue-50 border-blue-200' : 'bg-slate-50 border-slate-200' }}">
                                    <div>
                                        <p class="font-bold text-slate-800">
                                            {{ \Carbon\Carbon::parse($schedule->available_date)->format('l, F j, Y') }}
                                        </p>
                                        <p class="text-sm text-slate-600">
                                            {{ \Carbon\Carbon::parse($schedule->start_window)->format('g:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex items-center gap-4">
                                        @if($schedule->is_booked)
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full uppercase tracking-wider">Booked</span>
                                        @else
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full uppercase tracking-wider">Open</span>
                                            <form action="{{ route('counselor.schedules.destroy', $schedule->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold transition">Remove</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>