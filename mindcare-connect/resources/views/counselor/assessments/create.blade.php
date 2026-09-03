<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Assessment</h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <form method="POST" action="{{ route('counselor.assessments.store') }}">
                @csrf
                
                <div class="mb-4">
                    <x-input-label for="title" :value="__('Assessment Title (e.g., Daily Stress Check)')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus />
                </div>

                <div class="mb-4">
                    <x-input-label for="description" :value="__('Instructions / Description')" />
                    <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4"></textarea>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('counselor.assessments.index') }}" class="text-gray-600 hover:underline mr-4">Cancel</a>
                    <x-primary-button>Save Assessment</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>