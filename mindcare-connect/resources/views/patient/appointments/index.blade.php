<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Manage Appointments</h2></x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status')) <div class="bg-green-100 text-green-700 p-4 rounded">{{ session('status') }}</div> @endif

        <div class="bg-white p-6 shadow sm:rounded-lg">
            <table class="w-full text-left border-collapse">
                <tr class="border-b bg-gray-50"><th class="p-3">Patient Name</th><th class="p-3">Date & Time</th><th class="p-3">Status</th><th class="p-3">Action</th></tr>
                @foreach($appointments as $appt)
                <tr class="border-b">
                    <td class="p-3 font-bold">{{ $appt->patient->name }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-white text-xs 
                            {{ $appt->status === 'pending' ? 'bg-yellow-500' : ($appt->status === 'approved' ? 'bg-green-500' : 'bg-red-500') }}">
                            {{ strtoupper($appt->status) }}
                        </span>
                    </td>
                    <td class="p-3">
                        @if($appt->status === 'pending')
                            <form action="{{ route('counselor.appointments.updateStatus', $appt->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="text-green-600 hover:underline mr-2">Approve</button>
                            </form>
                            <form action="{{ route('counselor.appointments.updateStatus', $appt->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="text-red-600 hover:underline">Reject</button>
                            </form>
                        @else
                            <span class="text-gray-400 italic">No actions available</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>