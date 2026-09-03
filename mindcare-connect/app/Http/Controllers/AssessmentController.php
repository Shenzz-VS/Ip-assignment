<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;

class AssessmentController extends Controller
{
    // 1. Show all assessments
    public function index()
    {
        $assessments = Assessment::all();
        return view('counselor.assessments.index', compact('assessments'));
    }

    // 2. Show the form to create a new assessment
    public function create()
    {
        return view('counselor.assessments.create');
    }

    // 3. Save the new assessment to the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Assessment::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('counselor.assessments.index')->with('status', 'Assessment created successfully!');
    }

    // 4. Show the page to manage/add questions for an assessment
    public function show($id)
    {
        $assessment = Assessment::with('questions')->findOrFail($id);
        return view('counselor.assessments.show', compact('assessment'));
    }

    // 5. Store a new question for an assessment
    public function storeQuestion(Request $request, $id)
    {
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:text,rating,multiple_choice',
        ]);

        \App\Models\AssessmentQuestion::create([
            'assessment_id' => $id,
            'question_text' => $request->question_text,
            'question_type' => $request->question_type,
        ]);

        return redirect()->route('counselor.assessments.show', $id)->with('status', 'Question added successfully!');
    }
}