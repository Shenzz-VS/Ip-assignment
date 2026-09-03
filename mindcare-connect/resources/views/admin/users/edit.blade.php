<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            Edit {{ ucfirst($user->role) }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
        
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded shadow-sm mb-6">
                <p class="font-bold">Error</p>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-8 bg-slate-50 border-b border-slate-200">
                <h3 class="text-2xl font-bold text-slate-800">Account Details</h3>
                <p class="text-slate-600">Modify the system profile for this {{ $user->role }}.</p>
            </div>

            <div class="p-8">
                <!-- Smart Form: Changes route based on the user's role -->
                <form action="{{ $user->role === 'counselor' ? route('admin.counselors.update', $user->userID) : route('admin.patients.update', $user->userID) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" required class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 text-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ $user->email }}" required class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 text-lg">
                        </div>

                        <div class="pt-4 flex gap-4 border-t border-slate-100">
                            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold px-6 py-3 rounded-xl shadow-md transition">
                                Save Changes
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="bg-white hover:bg-slate-50 text-slate-700 border-2 border-slate-200 font-bold px-6 py-3 rounded-xl shadow-sm transition">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>