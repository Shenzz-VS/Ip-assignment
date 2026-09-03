<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Book an Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-8 bg-slate-50 border-b border-slate-200">
                <h3 class="text-2xl font-bold text-blue-900 mb-1">Schedule a Session</h3>
                <p class="text-slate-600">Select a counselor's available window and request your custom time slot.</p>
            </div>

            <div class="p-8">
                <!-- Display any validation errors -->
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded mb-6">
                        <p class="font-bold">Booking Error</p>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                @if($schedules->isEmpty())
                    <div class="text-center py-8">
                        <svg style="width: 3rem; height: 3rem;" class="mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h4 class="text-lg font-medium text-slate-900">No Windows Available</h4>
                        <p class="text-slate-500 mt-1">Our counselors currently have no open availability windows. Please check back later.</p>
                    </div>
                @else
                    <form action="{{ route('patient.appointments.store') }}" method="POST">
                        @csrf
                        
                        <!-- Choose Counselor's Available Window -->
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Available Counselor Windows</label>
                            
                            <!-- ADDED ID 'scheduleSelect' FOR JAVASCRIPT -->
                            <select name="schedule_id" id="scheduleSelect" required class="block w-full rounded-lg border-slate-300 shadow-sm p-3 bg-slate-50 focus:border-blue-500 focus:ring-blue-500">
                                <option value="" disabled selected>-- Select a date & window block --</option>
                                @foreach($schedules as $counselorId => $group)
                                    @foreach($group as $sch)
                                        
                                        <!-- ADDED data-start AND data-end TO PASS TIMES TO JAVASCRIPT -->
                                        <option value="{{ $sch->id }}" data-start="{{ $sch->start_window }}" data-end="{{ $sch->end_window }}">
                                            Dr. {{ $counselors[$counselorId]->name ?? 'Counselor' }} | 
                                            {{ \Carbon\Carbon::parse($sch->available_date)->format('M d, Y') }} 
                                            ({{ \Carbon\Carbon::parse($sch->start_window)->format('g:i A') }} - {{ \Carbon\Carbon::parse($sch->end_window)->format('g:i A') }})
                                        </option>
                                        
                                    @endforeach
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-500 mt-1">Choose a counselor's open window above, then pick your desired time block below (Max 2 hours).</p>
                        </div>

                        <!-- Choose Custom Times within the Window -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Desired Start Time</label>
                                <!-- ADDED ID 'startTimeInput' -->
                                <input type="time" name="start_time" id="startTimeInput" required class="block w-full rounded-lg border-slate-300 shadow-sm p-3 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Desired End Time</label>
                                <!-- ADDED ID 'endTimeInput' -->
                                <input type="time" name="end_time" id="endTimeInput" required class="block w-full rounded-lg border-slate-300 shadow-sm p-3 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Optional Notes -->
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Notes for Counselor (Optional)</label>
                            <textarea name="notes" rows="3" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="What would you like to focus on?"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition">
                            Request Custom Time Slot
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT TO LOCK THE TIME INPUTS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scheduleSelect = document.getElementById('scheduleSelect');
            const startTimeInput = document.getElementById('startTimeInput');
            const endTimeInput = document.getElementById('endTimeInput');

            if (scheduleSelect) {
                scheduleSelect.addEventListener('change', function() {
                    // 1. Get the currently selected option
                    const selectedOption = this.options[this.selectedIndex];
                    
                    // 2. Read the start and end windows from the database attributes
                    const minTime = selectedOption.getAttribute('data-start');
                    const maxTime = selectedOption.getAttribute('data-end');
                    
                    // 3. Lock the HTML time pickers to ONLY allow those specific times
                    if (minTime && maxTime) {
                        startTimeInput.min = minTime;
                        startTimeInput.max = maxTime;
                        
                        endTimeInput.min = minTime;
                        endTimeInput.max = maxTime;

                        // Reset the inputs so old invalid times don't carry over
                        startTimeInput.value = '';
                        endTimeInput.value = '';
                    }
                });
            }
        });
    </script>
</x-app-layout>