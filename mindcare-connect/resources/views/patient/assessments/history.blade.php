<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Progress Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Assessment History Banner -->
            <div class="bg-white border border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-md font-semibold text-gray-800">Assessment History</h3>
                    <p class="text-sm text-gray-600">Track your mental wellness journey over time. Your results are kept strictly confidential.</p>
                </div>
            </div>

            <!-- Table Container -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table style="width: 100%; table-layout: fixed" class="w-full min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th style="text-align: left" class="px-6 py-4 bg-white text-xs font-bold text-gray-900 uppercase tracking-wider border-b">Date Completed</th>
                                <th style="text-align: left" class="px-6 py-4 bg-white text-xs font-bold text-gray-900 uppercase tracking-wider border-b">Assessment Type</th>
                                <th style="text-align: left" class="px-6 py-4 bg-white text-xs font-bold text-gray-900 uppercase tracking-wider border-b">Status</th>
                                
                                <!-- NEW ACTION COLUMN HEADER -->
                                <th style="text-align: left" class="px-6 py-4 bg-white text-xs font-bold text-gray-900 uppercase tracking-wider border-b">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($assessments as $result)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($result->dateTaken ?? $result->created_at)->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($result->dateTaken ?? $result->created_at)->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $result->assessment->title ?? 'Daily Stress Check' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-100 text-gray-600 uppercase tracking-widest">
                                            RECORDED
                                        </span>
                                    </td>
                                    
                                    <!-- NEW VIEW FEEDBACK BUTTON -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('patient.assessments.result', $result->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-900 font-bold underline transition">
                                            View Feedback
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 whitespace-nowrap text-sm text-gray-500 text-center italic">
                                        No assessments recorded yet. Take an assessment to track your progress!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>