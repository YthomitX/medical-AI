<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // Show all users
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    // Update role
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:guest,admin',
        ]);

        $user->role = $request->role;
        $user->is_admin = $request->role === 'admin';
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User role updated!');
    }
}
