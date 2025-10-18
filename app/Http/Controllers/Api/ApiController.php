<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    // Register API - name, email, password, password_confirmation
    public function register(Request $request) {
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed"
        ]);

        User::create($request->all());

        return response()->json([
            "status" => true,
            "message" => "User Registered Successfully"
        ]);
    }

    // Login API
    public function login(Request $request) {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // User check By Email
        $user = User::where("email", $request->email)->first();

        // Password Check
        if(!empty($user)) {
            if(Hash::check($request->password, $user->password)) {
                $token = $user->createToken("myToken")->plainTextToken;

                return response()->json([
                    "status" => true,
                    "message" => "Logged In Successfully",
                    "token" => $token
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Password does not match"
                ]);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => "Email is invalid"
            ]);
        }
    }

    // Profile API
    public function profile() {
        $userdata = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "User Profile Data",
            "data" => $userdata,
            "id" => auth()->user()->id
        ]);
    }

    // Logout API
    public function logout() {
        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => true,
            "message" => "User Logged Out"
        ]);
    }
}
