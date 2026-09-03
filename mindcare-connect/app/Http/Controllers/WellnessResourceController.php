<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WellnessResource;

class WellnessResourceController extends Controller
{
    // 1. View all resources
    public function index()
    {
        $resources = WellnessResource::all();
        return view('counselor.wellness.index', compact('resources'));
    }

    // 2. Show the create form
    public function create()
    {
        return view('counselor.wellness.create');
    }

    // 3. Save to database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'tags'=> 'nullable|string',
            'video_url'=>'nullable|url',
            
        ]);

        \App\Models\WellnessResource::create([
            'admin_id'=>auth()->user()->userID,
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'tags' => $request->tags,
            'video_url' => $request->video_url, 
            'context_or_url'=>$request->video_url ?? 'System Resource',
        ]);

        return redirect()->route('counselor.wellness.index')->with('status', 'Wellness Resource added successfully!');
    }

    public function destroy($id){
        $resource = \App\Models\WellnessResource::findOrFail($id);
        $resource->delete();

        return redirect()->route('counselor.wellness.index')->with('status', 'Resource successfully deleted.');
    }
}