<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ucfirst(auth()->user()->role) }} {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Shared Welcome Banner -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                Welcome back, <strong>{{ auth()->user()->name }}</strong>!
            </div>

            <!-- Modular Includes -->
            @if(auth()->user()->role === 'patient')
                @include('patient.partials.overview')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6 border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Assessment History & Feedback</h3>
                    <p class="text-gray-600 mb-4">Review your past wellness assessments and read personalized feedback from your counselor.</p>
                    <a href="{{ route('patient.progress') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                        View My Progress
                    </a>
                </div>
            @elseif(auth()->user()->role === 'counselor')
                @include('counselor.partials.overview')
            @endif

        </div>
    </div>
</x-app-layout>