<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->user()->userID;

        // Get a list of users the current user has chatted with, or all available contacts
        $contacts = User::where('userID', '!=', $userId)->get();

        // Check who we are currently chatting with (default to the first contact if available)
        $selectedUserId = $request->input('receiver_id');
        $selectedUser = null;
        $messages = collect();

        if ($selectedUserId) {
            $selectedUser = User::where('userID', $selectedUserId)->first();
            
            // Fetch the chat history between auth user and selected user
            $messages = Message::where(function($query) use ($userId, $selectedUserId) {
                    $query->where('sender_id', $userId)->where('receiver_id', $selectedUserId);
                })->orWhere(function($query) use ($userId, $selectedUserId) {
                    $query->where('sender_id', $selectedUserId)->where('receiver_id', $userId);
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('messages.index', compact('contacts', 'selectedUser', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,userID',
            'body' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => auth()->user()->userID,
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
        ]);

        return redirect()->route('messages.index', ['receiver_id' => $request->receiver_id]);
    }
}