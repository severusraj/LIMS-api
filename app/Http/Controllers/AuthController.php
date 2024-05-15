<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request, string $subsystem) {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

            /*
            NOTE:
                Roles should be in ['superadmin', 'admin', 'staff', 'user']
                Input your subsystem to control login
            */

            $user = Auth::user();

            // Generate token for superadmin and admin only
            if($user->role == 'superadmin' && $subsystem == 'maintenance') {

                $token = $user->createToken('token-name', ['materials:edit', 'materials:view'])->plainTextToken;
                return response()->json(['token' => $token], 200);

            } else if(in_array($user->role, ['superadmin', 'admin']) && in_array($subsystem, ['cataloging', 'circulation'])) {

                $token = $user->createToken('token-name', ['materials:edit', 'materials:view'])->plainTextToken;
                return response()->json(['token' => $token], 200);

            } else if(in_array($user->role, ['user']) && in_array($subsystem, ['student'])) {

                $token = $user->createToken('token-name', ['materials:view'])->plainTextToken;
                return response()->json(['token' => $token], 200);

            } else {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function logout(Request $request) {
        try {
            auth()->user()->tokens()->delete();
            return response()->json(['Status' => 'Logged out successfully'], 200);
        } catch(Exception $e) {
            return response()->json(['Error' => $e->getMessage()], 400);
        }
    }
}
