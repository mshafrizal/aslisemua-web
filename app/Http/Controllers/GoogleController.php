<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\CustomersModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignInMail;

class GoogleController extends Controller
{
    public function __construct(){
        $this->CustomersModel = new CustomersModel();
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        try {
            $user = Socialite::driver('google')->user();

            $findUserMail = User::where('email', $user->email)->first();

            if ($findUserMail) {
                $findUserGoogleId = User::where('google_id', $user->getId())->first();
                if (empty($findUserGoogleId)) {
                    $userExisting = [
                        'google_id' => $user->getId(),
                        'level' => 'customer',
                        'is_first_time' => 'no'
                    ];
                    $this->CustomersModel->updateGoogleUser($user->getEmail(), $userExisting);
                }

                Auth::login($findUserGoogleId);
                return redirect()->intended('dashboard');
            }
            $newPassword = Str::random(12);
            $newUser = User::create([
                'id' => Str::uuid(),
                'password' => Hash::make($newPassword),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'google_id' => $user->getId(),
                'level' => 'customer',
                'is_verified' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_first_time' => 'yes'
            ]);

            $details = [
                'sender' => 'Asli Semua',
                'title' => 'Welcome to Asli Semua',
                'body' => [
                    'email' => $user->getEmail(),
                    'password' => $newPassword
                ]
            ];

            Mail::to($user->getEmail())->send(new SignInMail($details));

            Auth::login($newUser);
            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'error' => $e
            ]);
        }
    }
}
