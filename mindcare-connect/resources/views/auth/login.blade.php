<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="block mt-4 flex justify-between items-center">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-teal-600 hover:text-teal-800 font-medium transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Large Login Button -->
        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500" style="background-color: #0d9488;">
                {{ __('LOG IN') }}
            </button>
        </div>
        
        <!-- Registration Link separated below -->
        <div class="mt-6 text-center border-t border-slate-100 pt-4">
            <span class="text-sm text-slate-500">Don't have an account?</span>
            <a class="text-sm text-teal-600 hover:text-teal-800 font-bold ml-1 transition" href="{{ route('register') }}">
                Sign up here
            </a>
        </div>
    </form>
</x-guest-layout>