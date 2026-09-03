<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- NEW: View Profile Overview Card -->
        <div class="p-6 sm:p-8 bg-white shadow-sm sm:rounded-2xl border border-slate-200 flex flex-col sm:flex-row items-center gap-6">
            <div class="bg-teal-50 p-6 rounded-full border-2 border-teal-100 text-teal-600">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="text-center sm:text-left">
                <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ Auth::user()->name }}</h3>
                <p class="text-slate-500 text-lg mb-3">{{ Auth::user()->email }}</p>
                <span class="inline-block px-4 py-1 bg-teal-100 text-teal-800 text-sm font-bold rounded-full uppercase tracking-widest">
                    {{ Auth::user()->role ?? 'Patient' }} Account
                </span>
            </div>
        </div>

        <!-- Update Profile Form -->
        <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-2xl border border-slate-200">
            <div class="max-w-xl">
                <h3 class="text-lg font-bold text-slate-800 mb-1">Update Information</h3>
                <p class="text-sm text-slate-500 mb-6">Ensure your account details and email address are up to date.</p>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Password Management Form -->
        <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-2xl border border-slate-200">
            <div class="max-w-xl">
                <h3 class="text-lg font-bold text-slate-800 mb-1">Change Password</h3>
                <p class="text-sm text-slate-500 mb-6">Ensure your account is using a long, random password to stay secure.</p>
                @include('profile.partials.update-password-form')
            </div>
        </div>
        
    </div>
</x-app-layout>