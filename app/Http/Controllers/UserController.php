<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'department' => 'nullable|string',
            'position' => 'nullable|string',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'ext_name' => 'nullable|string|max:255',
            'access' => 'required|array',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'department' => $validated['department'],
            'position' => $validated['position'],
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'ext_name' => $validated['ext_name'],
            'access' => $validated['access'],
        ]);

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|string',
            'department' => 'nullable|string',
            'position' => 'nullable|string',
            'first_name' => 'sometimes|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'ext_name' => 'nullable|string|max:255',
            'access' => 'sometimes|array',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
