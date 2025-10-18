<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
    public function login() {

    }

    // Profile API
    public function profile() {

    }

    // Logout API
    public function logout() {

    }
}
