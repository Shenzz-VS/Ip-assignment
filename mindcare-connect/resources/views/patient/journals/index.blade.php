<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Daily Mood Journal</h2></x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status')) <div class="bg-green-100 text-green-700 p-4 rounded">{{ session('status') }}</div> @endif

        <!-- Log Mood Form -->
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="font-bold text-lg mb-4">How are you feeling today?</h3>
            <form method="POST" action="{{ route('journals.store') }}">
                @csrf
                <div class="mb-4">
                    <x-input-label for="mood" value="Select Mood" />
                    <select name="mood" class="block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="Happy">😊 Happy</option>
                        <option value="Calm">😌 Calm</option>
                        <option value="Neutral">😐 Neutral</option>
                        <option value="Anxious">😰 Anxious</option>
                        <option value="Sad">😢 Sad</option>
                    </select>
                </div>
                <div class="mb-4">
                    <x-input-label for="notes" value="Private Journal Notes" />
                    <textarea name="notes" class="block w-full border-gray-300 rounded-md shadow-sm" rows="3" placeholder="Write your thoughts here..."></textarea>
                </div>
                <x-primary-button>Save Entry</x-primary-button>
            </form>
        </div>

        <!-- History -->
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="font-bold text-lg mb-4">Your Past Entries</h3>
            <div class="space-y-4">
                @foreach($journals as $journal)
                <div class="border p-4 rounded-md bg-gray-50">
                    <div class="flex justify-between font-bold text-indigo-700">
                        <span>{{ $journal->mood }}</span>
                        <span class="text-xs text-gray-500">{{ $journal->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <p class="text-gray-700 mt-2">{{ $journal->notes ?? 'No notes provided.' }}</p>
                </div>
                @endforeach
                @if($journals->isEmpty()) <p class="text-gray-500 italic">No entries logged yet.</p> @endif
            </div>
        </div>
    </div>
</x-app-layout>