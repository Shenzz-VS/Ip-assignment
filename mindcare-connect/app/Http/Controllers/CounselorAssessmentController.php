<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssessmentResult;

class CounselorAssessmentController extends Controller
{
    // 1. Show all patient assessments to the Counselor
   public function index()
    {
        $results = AssessmentResult::with(['patient', 'assessment'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // CHANGED: Pointing to a new 'patient_results' folder
        return view('counselor.patient_results.index', compact('results'));
    }

    // 2. Show the specific assessment so the Counselor can read it and reply
  public function show($id)
    {
        $result = AssessmentResult::with(['patient', 'assessment.questions'])->findOrFail($id);
        
        // CHANGED: Pointing to a new 'patient_results' folder
        return view('counselor.patient_results.show', compact('result'));
    }

    // 3. Save the feedback securely to the database
    public function store(Request $request, $id)
    {
        $request->validate([
            'score' => 'required|integer|min:0',
            'severityLevel' => 'required|string|max:100',
            'counselor_feedback' => 'required|string'
        ]);

        $result = AssessmentResult::findOrFail($id);
        
        // Update the database column we created earlier!
        $result->update([
            'score' => $request->score,
            'severityLevel' => $request->severityLevel,
            'counselor_feedback' => $request->counselor_feedback
        ]);

        return redirect()->route('counselor.assessments.results')
            ->with('success', 'Feedback submitted successfully to the patient!');
    }
}