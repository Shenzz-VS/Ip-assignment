<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Review Patient Assessment</h2>
    </x-slot>

    <div class="w-full max-w-none py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            <!-- Patient Info Header -->
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Patient: {{ $result->patient->name ?? 'Unknown' }}</h3>
                    <p class="text-gray-600">Submitted: {{ \Carbon\Carbon::parse($result->dateTaken ?? $result->created_at)->format('M d, Y - h:i A') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 uppercase tracking-wider font-bold">Assessment Type</p>
                    <p class="text-xl font-bold text-blue-700">{{ $result->assessment->title ?? 'Wellness Check' }}</p>
                </div>
            </div>

            <!-- Editable Assessment Results -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div>
                    <label for="score" class="block text-sm text-gray-500 uppercase tracking-wider mb-1 font-bold">Total Score</label>
                    <input form="feedback-form" id="score" name="score" type="number" min="0" required value="{{ old('score', $result->score) }}" class="w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md shadow-sm">
                    @error('score') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="severityLevel" class="block text-sm text-gray-500 uppercase tracking-wider mb-1 font-bold">Severity Level</label>
                    <input form="feedback-form" id="severityLevel" name="severityLevel" type="text" required value="{{ old('severityLevel', $result->severityLevel) }}" class="w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md shadow-sm">
                    @error('severityLevel') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <hr class="my-6 border-gray-200">

            <h3 class="text-xl font-bold text-slate-800 mb-4">Patient Answers</h3>
            @if($result->answers)
                <div class="space-y-4 mb-8">
                    @foreach($result->assessment->questions ?? [] as $index => $question)
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="font-semibold text-gray-800">{{ $index + 1 }}. {{ $question->question_text }}</p>
                            <p class="mt-2 text-gray-700">{{ $result->answers[$question->id] ?? 'No answer provided' }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mb-8 text-gray-500 italic">Answers were not recorded for this submission.</p>
            @endif

            <!-- The Feedback Form -->
            <h3 class="text-xl font-bold text-slate-800 mb-4">Provide Clinical Feedback</h3>
            
            <form id="feedback-form" action="{{ route('counselor.assessments.store_feedback', $result->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2 italic">Note: This feedback will be directly visible to the patient on their progress tracker.</p>
                    <textarea name="counselor_feedback" rows="6" required class="w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md shadow-sm" placeholder="Write your professional, empathetic feedback here...">{{ $result->counselor_feedback }}</textarea>
                </div>
                
                <div class="flex items-center gap-4 mt-6">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                        Submit Feedback
                    </button>
                    <a href="{{ route('counselor.assessments.results') }}" class="text-gray-600 hover:text-gray-900 underline font-medium text-sm">
                        Cancel & Return
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>