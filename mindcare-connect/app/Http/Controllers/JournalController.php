<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;

class JournalController extends Controller
{
    public function index(){
        $journals = Journal::where('patient_id', auth()->user()->userID)->latest()->get();
        return view('patient.journals.index', compact('journals'));
    }

    public function store(Request $request){
        $request->validate([
          'mood'=>'required|string',
          'notes'=>'nullable|string',
        ]);

        Journal::create([
            'patient_id' => auth()->user()->userID,
            'mood'=> $request->mood,
            'notes'=> $request->notes,
        ]);

        return back()->with('status', 'Mood Entry Logged successfully.');
    }
  
}
