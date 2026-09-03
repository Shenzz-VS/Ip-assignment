<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Manage Patient Appointments') }}
        </h2>
    </x-slot>

<div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-md">
    <h3 class="text-lg font-semibold text-blue-800">Next Patient Insights (API Integration)</h3>
    <p class="text-sm text-blue-700 mt-1">
        <strong>Current Mood Level:</strong> 
        <span class="px-2 py-1 bg-white rounded shadow-sm text-slate-700">
            {{ $nextPatientMood }}
        </span>
    </p>
</div>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        @if (session('status'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded shadow-sm mb-6">
                <p class="font-bold">Status Updated</p>
                <p>{{ session('status') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200">
            <div class="p-6">
                <h3 class="text-xl font-bold text-slate-800 mb-6">Booking Requests & Schedule</h3>
                
                @if($appointments->isEmpty())
                    <div class="text-center py-12 bg-slate-50 rounded-lg border border-slate-100">
                        <svg style="width: 3rem; height: 3rem;" class="mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-slate-500 text-lg">You currently have no patient appointments.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($appointments as $appointment)
                            <div class="border border-slate-200 rounded-xl p-5 hover:shadow-sm transition {{ $appointment->status === 'Pending' ? 'bg-orange-50/30 border-orange-200' : 'bg-white' }}">
                                <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                                    
                                    <!-- Patient Info & Time -->
                                    <div>
                                        <div class="flex items-center gap-3 mb-1">
                                            <h4 class="font-bold text-lg text-slate-900">{{ $appointment->patient_name }}</h4>
                                            
                                            <!-- Status Badge -->
                                            @if($appointment->status === 'Pending')
                                                <span class="px-2.5 py-0.5 bg-orange-100 text-orange-800 text-xs font-bold rounded uppercase tracking-wider">Pending</span>
                                            @elseif($appointment->status === 'Approved')
                                                <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded uppercase tracking-wider">Approved</span>
                                            @else
                                                <span class="px-2.5 py-0.5 bg-red-100 text-red-800 text-xs font-bold rounded uppercase tracking-wider">Rejected</span>
                                            @endif
                                        </div>
                                        
                                        <p class="text-sm font-semibold text-slate-800">
    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('D, M d, Y') }}
</p>
<p class="text-xs text-blue-600 font-bold">
    Requested Time: {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('g:i A') }}
</p>
<p class="text-[11px] text-slate-400">
    (Within Window: {{ \Carbon\Carbon::parse($appointment->start_window)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_window)->format('g:i A') }})
</p>
                                        
                                        @if($appointment->notes)
                                            <div class="mt-3 bg-slate-50 p-3 rounded border border-slate-100 text-sm text-slate-700">
                                                <strong>Patient Note:</strong> "{{ $appointment->notes }}"
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Action Buttons (Only show if Pending) -->
                                    @if($appointment->status === 'Pending')
                                        <div class="flex gap-2 min-w-max">
                                            <!-- Approve Form -->
                                            <form action="{{ route('counselor.appointments.update', $appointment->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Approved">
                                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded shadow-sm text-sm font-bold transition">
                                                    Approve
                                                </button>
                                            </form>

                                            <!-- Reject Form -->
                                            <form action="{{ route('counselor.appointments.update', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this appointment? The time slot will become available for other patients.');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Rejected">
                                                <button type="submit" class="bg-white hover:bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded shadow-sm text-sm font-bold transition">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>