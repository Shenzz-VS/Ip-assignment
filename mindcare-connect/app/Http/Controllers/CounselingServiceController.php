<?php

namespace App\Http\Controllers;

use App\Models\CounselingService;
use Illuminate\Http\Request;

class CounselingServiceController extends Controller
{
    public function index()
    {
        $services = CounselingService::all();
        return view('counselor.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        CounselingService::create([
            'counselor_id' => auth()->id(),
            'name'=> $request->name,
            'duration_minutes' => $request->duration_minutes,
            'price'=>$request->price,
        ]);

        return redirect()->route('counselor.services.index')->with('status', 'Service added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'duration_minutes'=> 'required|integer|min:15',
            'price' => 'required|numeric|min:0',

        ]);

        $service = CounselorService::findOrFail($id);
        $service->update($request-only(['name', 'duration_minutes', 'price']));

        return redirect()->back()->with('status', 'Service updated successfully!');
    }

    public function destroy($id)
    {
        CounselingService::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'Service deleted successfully!');
    }
}