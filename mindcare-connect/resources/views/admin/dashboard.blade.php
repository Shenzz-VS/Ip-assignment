<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('System Administration') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        <!-- Status / Success Message -->
        @if (session('status'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-sm mb-8">
                <p class="font-bold">System Update</p>
                <p>{{ session('status') }}</p>
            </div>
        @endif
        
        <!-- System Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 border-l-4 border-l-blue-500">
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Total Users</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalUsers }}</h3>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 border-l-4 border-l-teal-500">
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Active Patients</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalPatients }}</h3>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 border-l-4 border-l-indigo-500">
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Counselors</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalCounselors }}</h3>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 border-l-4 border-l-purple-500">
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Appointments</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalAppointments }}</h3>
            </div>
        </div>

        <!-- User Management Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200">
            <div class="p-8 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-1">User Management</h3>
                    <p class="text-slate-600">Review, update, or remove system access for clinical staff and patients.</p>
                </div>
            </div>
            
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white">
                            <th class="border-b-2 border-slate-100 py-4 px-6 text-sm font-bold text-slate-600 uppercase tracking-wider">Name</th>
                            <th class="border-b-2 border-slate-100 py-4 px-6 text-sm font-bold text-slate-600 uppercase tracking-wider">Email</th>
                            <th class="border-b-2 border-slate-100 py-4 px-6 text-sm font-bold text-slate-600 uppercase tracking-wider">Role</th>
                            <th class="border-b-2 border-slate-100 py-4 px-6 text-sm font-bold text-slate-600 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through Counselors -->
                        @foreach($counselors as $counselor)
                            <tr class="hover:bg-slate-50 transition border-b border-slate-100">
                                <td class="py-4 px-6 text-slate-800 font-bold">Dr. {{ $counselor->name }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $counselor->email }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-bold rounded-full uppercase">Counselor</span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.counselors.edit', $counselor->userID) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold p-2">Edit</a>
                                        <form action="{{ route('admin.counselors.destroy', $counselor->userID) }}" method="POST" onsubmit="return confirm('WARNING: Deleting a counselor will also delete their schedules and appointments. Proceed?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold p-2">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <!-- Loop through Patients -->
                        @foreach($patients as $patient)
                            <tr class="hover:bg-slate-50 transition border-b border-slate-100">
                                <td class="py-4 px-6 text-slate-800 font-medium">{{ $patient->name }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $patient->email }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 bg-teal-100 text-teal-800 text-xs font-bold rounded-full uppercase">Patient</span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.patients.edit', $patient->userID) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold p-2">Edit</a>
                                        <form action="{{ route('admin.patients.destroy', $patient->userID) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this patient from the system?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold p-2">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>