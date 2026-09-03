<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Assessments</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Status Message -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-4 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <!-- Create Button (Moved inside the main container) -->
        <div class="mb-6 flex justify-end">
            <a href="{{ route('counselor.assessments.create') }}" class="bg-indigo-600 text-black px-4 py-2 rounded-md hover:bg-indigo-700 font-bold shadow-sm">
                + Create New Assessment
            </a>
        </div>

        <!-- Assessments Table -->
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="p-3">Title</th>
                        <th class="p-3">Description</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assessments as $assessment)
                    <tr class="border-b">
                        <td class="p-3 font-bold">{{ $assessment->title }}</td>
                        <td class="p-3 text-gray-600">{{ $assessment->description }}</td>
                        <td class="p-3">
                            <a href="{{ route('counselor.assessments.show', $assessment->id) }}" class="text-indigo-600 hover:underline">Manage Questions</a>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if($assessments->isEmpty())
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">No assessments created yet.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
    </div>
</x-app-layout>