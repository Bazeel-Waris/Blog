<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|max:50',
            'password' => 'required|max:255',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->save();

       // $token = $user->createToken('userAuthToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            //'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $token = $user->createToken('userAuthToken')->plainTextToken;
            return response()->json(['user' => $user, 'token' => $token]);
        }

        return response()->json(['message' => 'Unauthorized User'], 401);
    }

}
