<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
            {{ __('Secure Clinical Inbox') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Upgraded Flexbox Container with fixed minimum height -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-300 flex flex-col md:flex-row" style="min-height: 600px;">
            
            <!-- Left Panel: Contact List -->
            <div class="w-full md:w-1/3 border-b md:border-b-0 md:border-r border-slate-300 bg-slate-50 p-6">
                <h3 class="text-base font-extrabold text-slate-800 uppercase tracking-widest mb-6">Conversations</h3>
                
                <div class="space-y-4">
                    @foreach($contacts as $contact)
                        <!-- Contact Card (Clickable!) -->
                        <a href="{{ route('messages.index', ['receiver_id' => $contact->userID]) }}" 
                           class="block p-5 rounded-xl transition {{ isset($selectedUser) && $selectedUser->userID === $contact->userID ? 'bg-blue-700 text-white shadow-md ring-2 ring-blue-300' : 'bg-white hover:bg-blue-50 text-slate-900 border-2 border-slate-200 shadow-sm' }}">
                            <p class="font-bold text-lg">{{ $contact->name }}</p>
                            <p class="text-xs font-bold opacity-90 uppercase tracking-wider mt-1">{{ $contact->role }}</p>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Right Panel: Chat Window -->
            <div class="w-full md:w-2/3 flex flex-col justify-between p-6 bg-white">
                
                <!-- IF A USER IS CLICKED: Show Chat -->
                @if(isset($selectedUser))
                    
                    <!-- Chat Header -->
                    <div class="border-b-2 border-slate-100 pb-4 mb-4">
                        <h3 class="text-2xl font-extrabold text-slate-900">Chat with {{ $selectedUser->name }}</h3>
                        <p class="text-sm text-blue-600 font-bold uppercase tracking-wider mt-1">Encrypted Communication Channel</p>
                    </div>

                    <!-- Message Feed -->
                    <div class="flex-grow overflow-y-auto space-y-4 pr-4 mb-6 max-h-[400px]">
                        @if($messages->isEmpty())
                            <div class="text-center bg-slate-50 rounded-xl p-8 border border-slate-200 mt-8">
                                <p class="text-slate-600 font-medium text-lg">No messages yet.</p>
                                <p class="text-slate-500 mt-2">Start the conversation using the box below.</p>
                            </div>
                        @else
                            @foreach($messages as $msg)
                                <div class="flex {{ $msg->sender_id === auth()->user()->userID ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-md rounded-2xl px-5 py-4 shadow-sm {{ $msg->sender_id === auth()->user()->userID ? 'bg-blue-700 text-white rounded-br-none' : 'bg-slate-100 text-slate-900 border border-slate-200 rounded-bl-none' }}">
                                        <p class="text-base font-medium">{{ $msg->body }}</p>
                                        <span class="block text-xs mt-2 text-right opacity-75 font-semibold">{{ $msg->created_at->format('g:i A') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- The Input Field -->
                    <form action="{{ route('messages.store') }}" method="POST" class="flex gap-3 pt-4 border-t-2 border-slate-100">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $selectedUser->userID }}">
                        <input type="text" name="body" required placeholder="Type your message here..." class="flex-grow rounded-xl border-2 border-slate-300 focus:border-blue-600 focus:ring-blue-600 shadow-sm text-lg p-3 text-slate-900 font-medium">
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-extrabold text-lg px-8 py-3 rounded-xl shadow-md transition">
                            Send
                        </button>
                    </form>

                <!-- IF NO USER IS CLICKED: Show Empty State -->
                @else
                    <div class="flex flex-col items-center justify-center h-full text-center py-24">
                        <div class="bg-slate-100 p-6 rounded-full mb-6">
                            <svg style="width: 4rem; height: 4rem;" class="text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h4 class="text-2xl font-extrabold text-slate-900 mb-2">Select a conversation</h4>
                        <p class="text-lg text-slate-600 font-medium">Click on a contact's name from the left panel to open the chat and begin messaging.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>