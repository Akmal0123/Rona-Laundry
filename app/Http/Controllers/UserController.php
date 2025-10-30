<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Get all users (for admin)
    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users]);
    }

    // Store a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_user'   => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',
            'no_whatsapp' => 'nullable|string|max:20',
            'alamat'      => 'nullable|string|max:255',
            'role'        => 'required|string|max:50',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        return response()->json(['message' => 'User created', 'data' => $user], 201);
    }

    // Show user by id
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['data' => $user]);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'nama_user'   => 'sometimes|required|string|max:255',
            'email'       => 'sometimes|required|email|unique:users,email,' . $id,
            'password'    => 'nullable|string|min:6',
            'no_whatsapp' => 'nullable|string|max:20',
            'alamat'      => 'nullable|string|max:255',
            'role'        => 'sometimes|required|string|max:50',
        ]);
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);
        return response()->json(['message' => 'User updated', 'data' => $user]);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
