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
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                $success['name'] =  $user->name;
                $success['id'] = $user;

                return response()->json([
                    'status' => 200,
                    'message' => 'User has been successfully sign in',
                    'data' => $success
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Bad Request'
            ], 401);
        } catch (\Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'error' => $error->getMessage()
            ], 500);
        }
    }
}
