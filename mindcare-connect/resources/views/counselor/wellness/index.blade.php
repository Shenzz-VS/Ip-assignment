<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Manage Wellness Resources') }}
            </h2>
            
            <!-- THE "ADD RESOURCE" BUTTON -->
            <a href="{{ route('counselor.wellness.create') }}" class="bg-teal-600 hover:bg-teal-700 text-black font-bold py-2 px-4 rounded-lg shadow-sm transition flex items-center gap-2">
                <svg style="width: 1.25rem; height: 1.25rem;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New Resource
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Status / Success Message -->
        @if (session('status'))
            <div class="bg-teal-50 border-l-4 border-teal-500 text-teal-800 p-4 rounded shadow-sm mb-6">
                <p class="font-bold">Success!</p>
                <p>{{ session('status') }}</p>
            </div>
        @endif

        <!-- Resource List Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- NOTE: Make sure the variable below matches your controller (e.g., $resources or $wellnessResources) -->
            @foreach($resources as $resource)
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">
                    
                    <!-- Display Video if it exists -->
                    @if($resource->video_url)
                        <div class="bg-slate-900 w-full" style="position: relative; padding-bottom: 56.25%; height: 0;">
                            <iframe src="{{ $resource->embed_url }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="p-6 flex flex-col flex-grow">
                        <h4 class="text-xl font-bold text-slate-800 mb-2">{{ $resource->title }}</h4>
                        <p class="text-slate-600 mb-4 flex-grow">{{ $resource->description }}</p>
                        
                        <!-- Card Footer with Tag and Delete Button -->
                        <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                            <span class="text-xs font-semibold px-3 py-1 bg-blue-50 text-blue-700 rounded-full">
                                {{ $resource->tags ?? 'General' }}
                            </span>
                            
                            <!-- THE DELETE BUTTON -->
                            <form action="{{ route('counselor.wellness.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this resource? Patients will no longer be able to see it.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-sm flex items-center gap-1 transition p-2 rounded hover:bg-red-50">
                                    <svg style="width: 1rem; height: 1rem;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Empty State (If no resources exist) -->
        @if($resources->isEmpty())
            <div class="text-center bg-white p-12 rounded-xl shadow-sm border border-slate-200">
                <!-- GIANT ICON FIX APPLIED HERE -->
                <svg style="width: 3rem; height: 3rem;" class="mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <p class="text-slate-500 text-lg">You haven't added any wellness resources yet.</p>
            </div>
        @endif
    </div>
</x-app-layout>