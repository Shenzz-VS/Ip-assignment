<div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
    <h3 class="text-lg font-bold text-green-800">Counselor Workspace</h3>
    <p class="text-sm text-green-700">Your specific counselor features will go here.</p>
</div>
<div class="mt-6 flex space-x-4">
    <a href="{{ route('counselor.services.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Manage Services</a>
    <a href="{{ route('counselor.schedules.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">Manage Schedule</a>
    <a href="{{ route('counselor.appointments.index') }}" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">View Appointments</a>
</div>