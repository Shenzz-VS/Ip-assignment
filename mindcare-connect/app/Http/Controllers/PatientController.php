<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PatientController extends Controller
{
    public function edit($id)
    {
        $user = User::where('role', 'patient')->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'patient')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            // Ensure the email is unique, but ignore this specific user's ID
            'email' => 'required|email|unique:users,email,' . $id . ',userID', 
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('admin.dashboard')->with('status', 'Patient account successfully updated.');
    }

    public function destroy($id)
    {
        $user = User::where('role', 'patient')->findOrFail($id);
        $user->delete(); // This will cascade and delete their journals/appointments automatically!

        return redirect()->route('admin.dashboard')->with('status', 'Patient account permanently removed.');
    }
}