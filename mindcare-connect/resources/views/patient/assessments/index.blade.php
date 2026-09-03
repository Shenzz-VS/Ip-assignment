<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Available Assessments</h2>
    </x-slot>
    
<!-- Success/Congratulatory Message -->
        @if (session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-5 rounded shadow-sm mb-6 flex items-center">
                <!-- A nice little checkmark icon -->
                <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-semibold text-lg">{{ session('status') }}</span>
            </div>
        @endif

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            @foreach($assessments as $assessment)
            <div class="bg-white p-6 shadow-md rounded-lg border-t-4 border-indigo-500 flex flex-col h-full">
                
                <div class="flex-grow">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $assessment->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ $assessment->description }}</p>
                </div>
                
                <div class="mt-6 pt-4 border-t border-gray-100 text-right w-full">
                    <a href="{{ route('patient.assessments.show', $assessment->id) }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 font-semibold shadow-sm transition">
                        Take Assessment &rarr;
                    </a>
                </div>
                
            </div>
            @endforeach

            @if($assessments->isEmpty())
                <div class="col-span-2 text-center text-gray-500 bg-white p-6 rounded-lg shadow-sm">
                    No assessments are currently available. Please check back later.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>