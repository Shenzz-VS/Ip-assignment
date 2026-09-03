<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Counseling Services</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <!-- Status Messages -->
        @if(session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add New Service Form -->
        <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-100">
            <h3 class="text-lg font-bold mb-4 text-indigo-800">Add New Service</h3>
            <form method="POST" action="{{ route('counselor.services.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Service Name</label>
                    <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" required placeholder="e.g., CBT Session">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Duration (Minutes)</label>
                    <input type="number" name="duration_minutes" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" value="60" min="15" step="15" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price (RM)</label>
                    <input type="number" step="0.01" min="0" name="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" value="0.00" required>
                </div>
                <div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium w-full py-2 px-4 rounded-md shadow-sm transition">
                        Add Service
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Services Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-bold mb-4 text-gray-800">Existing Services</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="py-3 px-4 border-b text-left">Service Name</th>
                            <th class="py-3 px-4 border-b text-left">Duration (Mins)</th>
                            <th class="py-3 px-4 border-b text-left">Price (RM)</th>
                            <th class="py-3 px-4 border-b text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($services as $service)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <input form="update-form-{{ $service->id }}" type="text" name="name" value="{{ $service->name }}" class="border-gray-300 rounded-md text-sm w-full focus:ring-indigo-500 focus:border-indigo-500" required>
                                </td>
                                <td class="py-3 px-4">
                                    <input form="update-form-{{ $service->id }}" type="number" name="duration_minutes" value="{{ $service->duration_minutes }}" min="15" step="15" class="border-gray-300 rounded-md text-sm w-24 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </td>
                                <td class="py-3 px-4">
                                    <input form="update-form-{{ $service->id }}" type="number" step="0.01" min="0" name="price" value="{{ $service->price }}" class="border-gray-300 rounded-md text-sm w-32 focus:ring-indigo-500 focus:border-indigo-500" required>
                                </td>
                                <td class="py-3 px-4 text-center space-x-2">
                                    <!-- Hidden Update Form -->
                                    <form id="update-form-{{ $service->id }}" action="{{ route('counselor.services.update', $service->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-indigo-600 text-white px-3 py-1.5 rounded-md text-xs hover:bg-indigo-700 transition">
                                            Update
                                        </button>
                                    </form>

                                    <!-- Delete Form -->
                                    <form action="{{ route('counselor.services.destroy', $service->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this service?');">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1.5 rounded-md text-xs hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500 italic">No counseling services added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>