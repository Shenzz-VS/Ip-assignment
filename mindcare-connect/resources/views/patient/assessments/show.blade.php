<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $assessment->title }}</h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <p class="text-gray-600 mb-6 pb-4 border-b">{{ $assessment->description }}</p>

            <form method="POST" action="{{ route('patient.assessments.store', $assessment->id) }}">
                @csrf
                
                @foreach($assessment->questions as $index => $question)
                <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
                    <label class="block font-bold text-gray-800 mb-2">
                        {{ $index + 1 }}. {{ $question->question_text }}
                    </label>

                    @if($question->question_type === 'rating')
                        <select name="answers[{{ $question->id }}]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select a rating...</option>
                            <option value="1">1 - Strongly Disagree / Never</option>
                            <option value="2">2 - Disagree / Rarely</option>
                            <option value="3">3 - Neutral / Sometimes</option>
                            <option value="4">4 - Agree / Often</option>
                            <option value="5">5 - Strongly Agree / Always</option>
                        </select>
                    @elseif($question->question_type === 'multiple_choice')
                    <!-- Your New Hardcoded Multiple Choice Dropdown -->
                        <select name="answers[{{ $question->id }}]" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select your answer...</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="Sometimes">Sometimes</option>
                        </select>
                        @else
                        <textarea name="answers[{{ $question->id }}]" class="block w-full border-gray-300 rounded-md shadow-sm" rows="3" required></textarea>
                    @endif
                </div>
                @endforeach

                <div class="flex justify-end mt-6">
                    <x-primary-button class="bg-green-600 hover:bg-green-700">Submit Answers</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>