<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateProfile extends Controller
{
    public function getProfileInfo()
    {
        $user = \auth()->user();
        return response()->json([
            "status" => true,
            "message" => "Profile information",
            "data" => $user,
            "id" => \auth()->user()->id
        ]);
    }

    public function setProfileInfo(Request $request)
    {
        //TODO: add validation if email already exists in db before updating it
        $validator = Validator::make($request->all(), [
            'firstName' => 'sometimes|required|string|max:255',
            'lastName' => 'sometimes|required|string|max:255',
            'phoneNumber' => 'sometimes|nullable|string|max:20',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . \auth()->user()->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        $user = \auth()->user();

        if ($request->has('firstName')) {
            $user->first_name = $request->input('firstName');
        }
        if ($request->has('lastName')) {
            $user->last_name = $request->input('lastName');
        }
        if ($request->has('phoneNumber')) {
            $user->phone_number = $request->input('phoneNumber');
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }


}
