<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Security Audit Log</h2></x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg border-t-4 border-red-800">
            <h3 class="font-bold text-lg mb-4">System Activity Trail</h3>
            
            <table class="w-full text-left border-collapse">
                <tr class="border-b bg-gray-100">
                    <th class="p-3">Timestamp</th>
                    <th class="p-3">User</th>
                    <th class="p-3">Action</th>
                    <th class="p-3">Forensic Details</th>
                </tr>
                @foreach($logs as $log)
                <tr class="border-b hover:bg-gray-50 text-sm">
                    <td class="p-3 text-gray-500">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    <td class="p-3 font-bold">{{ $log->user ? $log->user->name : 'SYSTEM' }} ({{ $log->user ? $log->user->role : 'N/A' }})</td>
                    <td class="p-3"><span class="bg-gray-200 px-2 py-1 rounded font-mono">{{ $log->action }}</span></td>
                    <td class="p-3 text-gray-700">{{ $log->details }}</td>
                </tr>
                @endforeach
            </table>
            
            @if($logs->isEmpty())
                <p class="text-center text-gray-500 mt-6 italic">No security events have been recorded yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>