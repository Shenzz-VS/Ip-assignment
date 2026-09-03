<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CounselorController extends Controller
{
    public function edit($id)
    {
        $user = User::where('role', 'counselor')->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'counselor')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',userID', 
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('admin.dashboard')->with('status', 'Counselor account successfully updated.');
    }

    public function destroy($id)
    {
        $user = User::where('role', 'counselor')->findOrFail($id);
        $user->delete(); // Cascades to delete their schedules and appointments

        return redirect()->route('admin.dashboard')->with('status', 'Counselor account permanently removed.');
    }
}