<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Patient Submissions for Review</h2>
    </x-slot>

    <div class="w-full max-w-none py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            
            @if(session('success'))
                <div class="mb-6 font-bold text-sm text-green-800 bg-green-100 p-4 rounded-lg border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="text-lg font-bold mb-4 text-gray-800">Completed Assessments</h3>
            
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="w-full min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th style="text-align: left" class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                            <th style="text-align: left" class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Patient Name</th>
                            <th style="text-align: left" class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Assessment</th>
                            <th style="text-align: left" class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Score</th>
                            <th style="text-align: left" class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($results as $result)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($result->dateTaken ?? $result->created_at)->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $result->patient->name ?? 'Unknown Patient' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $result->assessment->title ?? 'Wellness Check' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $result->score ?? 'N/A' }} <span class="text-gray-500 text-xs font-normal">({{ $result->severityLevel ?? 'N/A' }})</span></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('counselor.assessments.show_result', $result->id) }}" class="text-blue-600 font-bold underline hover:text-blue-900">
                                    {{ $result->counselor_feedback ? 'Update Feedback' : 'Review & Reply' }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">No patient assessments have been submitted yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>