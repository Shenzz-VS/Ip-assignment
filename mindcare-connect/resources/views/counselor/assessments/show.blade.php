<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Assessment: {{ $assessment->title }}</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Status Message -->
        @if (session('status'))
            <div class="font-medium text-sm text-green-600 bg-green-100 p-4 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <!-- Existing Questions List -->
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="text-lg font-bold mb-4">Current Questions</h3>
            <ul class="space-y-3">
                @foreach($assessment->questions as $index => $question)
                <li class="border p-4 rounded-md flex justify-between items-center bg-gray-50">
                    <div>
                        <span class="font-bold text-gray-700">Q{{ $index + 1 }}:</span> {{ $question->question_text }}
                        <span class="ml-2 text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded">Type: {{ ucfirst($question->question_type) }}</span>
                    </div>
                </li>
                @endforeach
                @if($assessment->questions->isEmpty())
                <p class="text-gray-500">No questions added to this assessment yet.</p>
                @endif
            </ul>
        </div>

        <!-- Add New Question Form -->
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="text-lg font-bold mb-4">Add a New Question</h3>
            <form method="POST" action="{{ route('counselor.assessments.questions.store', $assessment->id) }}">
                @csrf
                
                <div class="mb-4">
                    <x-input-label for="question_text" :value="__('Question Text')" />
                    <x-text-input id="question_text" class="block mt-1 w-full" type="text" name="question_text" required placeholder="e.g., How often do you feel overwhelmed?" />
                </div>

                <div class="mb-4">
                    <x-input-label for="question_type" :value="__('Question Response Type')" />
                    <select id="question_type" name="question_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="rating">Rating Scale (e.g., 1 to 5)</option>
                        <option value="text">Open Text Response</option>
                        <option value="multiple_choice">Multiple Choice</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <x-primary-button>Add Question</x-primary-button>
                </div>
            </form>
        </div>

        <div class="flex justify-start">
            <a href="{{ route('counselor.assessments.index') }}" class="text-gray-600 hover:underline">&larr; Back to Assessments List</a>
        </div>

    </div>
</x-app-layout>