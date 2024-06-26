<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

    public function register(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => "Validation error",
                    "errors" => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            return response()->json([
                "status" => true,
                "message" => "User created successfully",
                "token" => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => "Validation error",
                    "errors" => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    "status" => false,
                    "message" => "Email and password does not match",
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            return response()->json([
                "status" => true,
                "message" => "User signed in successfully",
                "token" => $user->createToken("API TOKEN")->plainTextToken
            ]);


        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            "status" => true,
            "message" => "User logged out",
        ]);
    }

    public function validateToken(Request $request)
    {
        if (Auth::guard('sanctum')->check()) {
            return response()->json(['message' => 'Token is valid'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

}
