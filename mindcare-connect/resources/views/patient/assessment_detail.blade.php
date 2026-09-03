<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assessment Results & Feedback') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $result->assessment->title ?? 'Wellness Assessment' }}</h2>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        Completed: {{ \Carbon\Carbon::parse($result->dateTaken ?? $result->created_at)->format('M d, Y') }}
                    </span>
                </div>
                
                <!-- Results Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Total Score</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $result->score ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Severity Level</p>
                        <p class="text-xl font-semibold text-gray-700">{{ $result->severityLevel ?? 'N/A' }}</p>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <!-- Feedback Section -->
                <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    Counselor's Feedback
                </h3>
                
                @if($result->counselor_feedback)
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-200 shadow-inner">
                        <p class="text-slate-700 whitespace-pre-line leading-relaxed">{{ $result->counselor_feedback }}</p>
                    </div>
                @else
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-inner flex items-center">
                        <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-slate-500 italic">Your counselor is currently reviewing your results. Personalized feedback will be posted here soon.</p>
                    </div>
                @endif
                
                <!-- Back Button -->
                <div class="mt-8">
                    <a href="{{ route('patient.progress') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
                        &larr; Back to History
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>