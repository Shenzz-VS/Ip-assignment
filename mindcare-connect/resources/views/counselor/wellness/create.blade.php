<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Wellness Resource</h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <form method="POST" action="{{ route('counselor.wellness.store') }}">
                @csrf
                
                <div class="mb-4">
                    <x-input-label for="title" :value="__('Article Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus placeholder="e.g., 5 Ways to Manage Anxiety" />
                </div>

                <div class="mb-4">
                    <x-input-label for="description" :value="__('Short Summary')" />
                    <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" required placeholder="A brief description of this resource..." />
                </div>

                <div class="mb-4">
                    <x-input-label for="tags" :value="__('Resource Tag (Target Mood)')" />
                    <select name="tags" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">General (No specific tag)</option>
                        <option value="Happy">Happy</option>
                        <option value="Calm">Calm</option>
                        <option value="Neutral">Neutral</option>
                        <option value="Anxious">Anxious</option>
                        <option value="Sad">Sad</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Select the mood this article helps with to power the recommendation engine.</p>
                </div>

                <div class="mb-4">
                    <x-input-label for="content" :value="__('Full Content (or Link)')" />
                    <textarea id="content" name="content" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="8" required placeholder="Paste the full article text, advice, or a helpful link here..."></textarea>
                </div>

                <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Video Link (Optional YouTube/Video URL)</label>
                <input type="url" name="video_url" class="block w-full border-gray-300 rounded-md shadow-sm mt-1" placeholder="https://www.youtube.com/watch?v=...">
            </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('counselor.wellness.index') }}" class="text-gray-600 hover:underline mr-4">Cancel</a>
                    <x-primary-button>Publish Resource</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>