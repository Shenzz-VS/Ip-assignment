<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Patient Dashboard</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <!-- Status Message -->
        @if (session('status'))
            <div class="bg-teal-50 border-l-4 border-teal-500 text-teal-800 p-4 rounded shadow-sm mb-6" role="alert">
                <p class="font-bold">Success!</p>
                <p>{{ session('status') }}</p>
            </div>
        @endif

        <!-- Medical UI Welcome Banner -->
        <div class="rounded-2xl shadow-lg overflow-hidden mb-8" style="background: linear-gradient(to right, #0f766e, #1e40af);">
            <div class="p-8 text-white">
                <h2 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}</h2>
                <p class="text-teal-50 text-lg">Your mental wellness journey, supported and secure. Take a moment for yourself today.</p>
            </div>
        </div>

        <!-- Assessment Notification Widget & Quick Links -->
        <div class="mb-8 bg-blue-50 border border-blue-200 rounded-xl shadow-sm p-5 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-blue-900 font-bold text-lg">My Assessments</h4>
                    @if(isset($availableAssessments) && $availableAssessments > 0)
                        <p class="text-blue-700 text-sm">You have <strong>{{ $availableAssessments }}</strong> wellness assessment(s) ready to take.</p>
                    @else
                        <p class="text-blue-700 text-sm">You are all caught up on your assessments!</p>
                    @endif
                </div>
            </div>
            
            <!-- Grouped Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <a href="{{ route('patient.progress') }}" class="bg-white border-2 border-blue-600 text-blue-700 hover:bg-blue-50 px-5 py-2.5 rounded-lg shadow-sm font-semibold transition text-center whitespace-nowrap">
                    View Progress History
                </a>
                
                @if(isset($availableAssessments) && $availableAssessments > 0)
                    <a href="{{ route('patient.assessments.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow-sm font-semibold transition text-center whitespace-nowrap">
                        Take Assessment
                    </a>
                @endif
            </div>
        </div>

        <!-- Context-Aware Recommendations -->
        @if($currentMood && $recommendedResources->count() > 0)
            <div class="mb-8 p-6 bg-teal-50 border border-teal-100 rounded-xl shadow-sm">
                <h3 class="text-2xl font-bold text-teal-900 mb-2">Recommended for You</h3>
                <p class="text-teal-700 mb-6">Because you recently felt <strong>{{ $currentMood }}</strong>, we selected these specifically for you.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($recommendedResources as $resource)
                        <div class="bg-white rounded-xl shadow-sm border border-teal-100 overflow-hidden">
                            @if($resource->video_url)
                                <div class="bg-slate-900 w-full" style="position: relative; padding-bottom: 56.25%; height: 0;">
                                    <iframe src="{{ $resource->embed_url }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allowfullscreen></iframe>
                                </div>
                            @endif
                            <div class="p-6">
                                <h4 class="text-xl font-bold text-slate-800 mb-2">{{ $resource->title }}</h4>
                                <p class="text-slate-600 mb-4">{{ $resource->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Counseling Services Widget -->
        <div class="mb-8 bg-indigo-50 border border-indigo-200 rounded-xl shadow-sm p-5 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center">
                <div class="bg-indigo-100 p-3 rounded-full mr-4">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h4 class="text-indigo-900 font-bold text-lg">Counseling Services</h4>
                    <p class="text-indigo-700 text-sm">Need someone to talk to? Schedule a private, secure session with our mental health professionals.</p>
                </div>
            </div>
            
            <div class="flex w-full md:w-auto">
                <a href="{{ route('patient.appointments.create') }}" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-sm font-semibold transition text-center whitespace-nowrap">
                    Book an Appointment
                </a>
            </div>
        </div>
        <!-- NEW: My Appointments Tracker -->
        @if(isset($myAppointments) && $myAppointments->isNotEmpty())
            <div class="mb-8 p-6 bg-white border border-slate-200 rounded-xl shadow-sm">
                <h3 class="text-xl font-bold text-slate-800 mb-4">My Appointments</h3>
                <div class="space-y-3">
                    @foreach($myAppointments as $appt)
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center p-4 rounded-lg border {{ $appt->status === 'Pending' ? 'bg-orange-50 border-orange-100' : ($appt->status === 'Approved' ? 'bg-emerald-50 border-emerald-100' : 'bg-red-50 border-red-100') }}">
                            <div>
                                <p class="font-bold text-slate-800">Session with Dr. {{ $appt->counselor_name }}</p>
                                <p class="text-sm text-slate-600 font-medium">
                                    {{ \Carbon\Carbon::parse($appt->appointment_date)->format('D, M d, Y') }} <br>
                                    <span class="text-blue-600">{{ \Carbon\Carbon::parse($appt->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($appt->end_time)->format('g:i A') }}</span>
                                </p>
                            </div>
                            <div class="mt-2 sm:mt-0">
                                @if($appt->status === 'Pending')
                                    <span class="px-3 py-1 bg-orange-100 text-orange-800 text-xs font-bold rounded-full uppercase tracking-wider">Pending Approval</span>
                                @elseif($appt->status === 'Approved')
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full uppercase tracking-wider">Approved</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full uppercase tracking-wider">Declined</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- General Wellness Library -->
        <h3 class="text-2xl font-bold text-slate-800 mb-4">General Wellness Library</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($generalResources as $resource)
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                    
                    @if($resource->video_url)
                        <div class="bg-slate-900 w-full" style="position: relative; padding-bottom: 56.25%; height: 0;">
                            <iframe src="{{ $resource->embed_url }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endif

                    <div class="p-6">
                        <h4 class="text-xl font-bold text-slate-800 mb-2">{{ $resource->title }}</h4>
                        <p class="text-slate-600 mb-4">{{ $resource->description }}</p>
                        
                        @if($resource->content)
                            <div class="bg-slate-50 rounded-lg p-4 text-sm text-slate-700 border border-slate-200 mt-4">
                                <strong class="block mb-2 text-teal-600">Clinical Notes:</strong>
                                <div class="whitespace-pre-wrap">{{ $resource->content }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($generalResources->isEmpty() && $recommendedResources->isEmpty())
            <p class="text-slate-500 italic mt-4 text-center bg-white p-8 rounded-xl shadow-sm">No wellness resources are available right now. Check back later!</p>
        @endif
    </div>
</x-app-layout>