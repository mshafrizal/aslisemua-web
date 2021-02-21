<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    public function authenticate(Request $request) {
        try {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user = Auth::user();
                if ($user->status === 'inactive') return response()->json([
                    'status' => 400,
                    'message' => 'Your account is inactive'
                ], 400);

                if ($user->is_verified === 0 || $user->is_verified === '0') return response()->json([
                    'status' => 400,
                    'message' => 'You should verify first before you comein'
                ], 400);

                $data = $user;
                $data['token'] =  $user->createToken('MyApp')->accessToken;

                return response()->json([
                    'status' => 200,
                    'message' => 'User has been successfully sign in',
                    'data' => $data
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Bad Request'
            ], 400);
        } catch (\Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'error' => $error->getMessage()
            ], 500);
        }
    }
}
