<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssessmentResult;
use App\Models\Assessment;

class PatientAssessmentController extends Controller
{
    // 1. Show all available assessments
    public function index()
    {
        $assessments = Assessment::all();
        return view('patient.assessments.index', compact('assessments'));
    }

    // 2. Show the actual quiz form
    public function show($id)
    {
        $assessment = Assessment::with('questions')->findOrFail($id);

        return view('patient.assessments.show', compact('assessment'));
    }

    public function result($id)
    {
        $result = AssessmentResult::with('assessment')->findOrFail($id);

        if ($result->user_id !== auth()->user()->userID) {
            abort(403, 'Unauthorized access to assessment result.');
        }

        return view('patient.assessment_detail', compact('result'));
    }
    // 3. Calculate and save the results
    public function store(Request $request, $id)
    {
        $assessment = Assessment::with('questions')->findOrFail($id);
        $answers = $request->input('answers', []);

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        // For this module, we will do a simple calculation of 'rating' questions
        $totalScore = 0;

        foreach ($answers as $answer) {
            if (is_numeric($answer)) {
                $totalScore += (int) $answer;
            }
        }

        // Save the final result to the database
        AssessmentResult::create([
            'user_id' => auth()->user()->userID,
            'assessment_id' => $assessment->id,
            'score' => $totalScore,
            'answers' => $answers,
        ]);

        return redirect()->route('patient.dashboard')->with('status', 'Assessment completed! Thank you for taking the time to check in with yourself today.');
    }
        public function history()
    {
        // 1. Fetch all assessment results for the logged-in patient
        // We use 'with('assessment')' so it efficiently loads the related Assessment title!
        $assessments = \App\Models\AssessmentResult::with('assessment')
            ->where('user_id', auth()->user()->userID) // Ensure they only see THEIR results
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Pass the exactly named '$assessments' variable to your history view
        return view('patient.assessments.history', compact('assessments'));
    }
}