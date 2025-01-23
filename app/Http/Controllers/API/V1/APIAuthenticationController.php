<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\LoginRequest;
use App\Http\Requests\API\V1\LogoutRequest;
use Illuminate\Support\Facades\Auth;

class APIAuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) { // If the credentials are correct, log the user in
            $token = $request->user()->createToken('SoftxpertTaskManagementRESTAPI');


            return response()->json([
                'message' => 'Logged in successfully!',
                'token'   => $token->plainTextToken
            ], 200);
        }


        // If the credentials are incorrect, login fails and return an error response
        return response()->json([
            'message' => 'Unauthorized'
        ], 401); // 401 Unauthorized
    }

    public function logout(LogoutRequest $request)
    {
        $request->user()->tokens()->delete(); // Delete all tokens associated with the authenticated user (log the user out from everywhere (all devices/sessions))
        // $request->user()->currentAccessToken()->delete(); // Delete the token that was used to authenticate the current request (delete the current token that the user is using to authenticate the request) (log the user out from the current session only (single token))


        return response()->json([
            'message' => 'Logged out successfully!'
        ], 200);
    }

}
