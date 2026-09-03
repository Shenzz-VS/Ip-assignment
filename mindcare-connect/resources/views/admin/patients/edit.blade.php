<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Patient</h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <form action="{{ route('admin.patients.update', $patient->userID) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $patient->name) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $patient->email) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">New Password <span class="text-xs text-gray-400">(Leave blank to keep current)</span></label>
                    <input type="password" name="password" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>