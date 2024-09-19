<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => 'Berhasil',
            'data' => $users,
        ], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'role' => 'required',
            'password' => 'required|string'
        ]);

        if (User::where('name', $request->name)->exists()) {
            return response()->json([
                'message' => 'username is already taken'
            ], 400);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Gagal',
                'message' => $validator->errors()
            ], 400);
        }

        $users = new User();
        $users->name = $request->name;
        $users->role = $request->role;
        $users->password = bcrypt($request->password);
        $users->save();

        return response()->json([
            'status' => 'berhasil',
            'data' => $users
        ], 200);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('name', 'password'))) {
            return response()->json(['success' => false, 'message' => 'Login failed! Check your credentials!'], 401);
        }

        $user = User::where('name', $request->name)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'berhasil log in',
            // 'data' => $user,
            'role' => $user->role,
            'name' => $user->name,
            'token' => $token,
        ]);
    }

    public function getUserInfo()
    {
        $user = Auth::user();

        return response()->json([
            'name' => $user->name,
            'role' => $user->role
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            "message" => "{$user->name} successfully logged out",

        ]);
    }
}
