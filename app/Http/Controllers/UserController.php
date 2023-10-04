<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function deleteUser(Request $request)
    {
        $user = User::find($request->id);

        $currentUser = auth()->user();

        return response()->json([
            'Status' => $user,
            'Status' => $currentUser,
        ]);
        if($currentUser->id == $user->id)
        {
            $user->delete();

            return response()->json([
                'Status' => 'User Has been Deleted!',
            ]);
        }
        else
        {
            return response()->json([
                'Status' => 'could not delete the user!',
                'Goto' => redirect('/')
            ]);
        }
    }

    public function editUser(Request $request)
    {
        $user = User::find($request->id);

        $currentUser = auth()->user();

        if($currentUser->id == $user->id)
        {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|max:255',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->isAdmin = false;

            $user->save();

            return response()->json([
                'Status' => 'User Has been updated successfully!'
            ]);
        }
        else
        {
            return response()->json([
                'Status' => 'User is not Authenticated!'
            ]);
        }

    }

    public function getUser(Request $request)
    {
        $user = User::find($request->id);

        return response()->json([
            'User Profile' => $user
        ]);
    }

    public function getAllUsers()
    {
        $users = User::all();
        $admin = auth()->user();

        // array_shift($user[0]);
        if($admin->isAdmin)
        {
            return response()->json([
                'All Users' => $users
            ], 200);
        }
        else
        {
            return response()->json([
                'Message' => 'Not Allowed to access Page'
            ], 404);
        }

    }

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
        $user->isAdmin = false;
        $user->save();

        return response()->json([
            'user' => $user,
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
