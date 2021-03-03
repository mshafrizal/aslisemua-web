<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\CustomersModel;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Mail\RegisterMail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use URL;
class CustomersController extends Controller
{
    public function __construct(){
        $this->CustomersModel = new CustomersModel();
    }

    public function create() {
        try {
            Request()->validate(
                [
                    'name' => 'required|max:50',
                    'email' => 'required|email:rfc,dns|unique:customers',
                    'gender' => 'required|max:10',
                    'password' => 'required|min:6',
                    'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|max:13',
                    'postal_code' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
                    'city' => 'required',
                    'district' => 'required|max:50',
                    'address' => 'required|max:255',
                ]
            );

            $dataValidated = [
                'id' => Str::uuid(),
                'name' => Request()->name,
                'email' => Request()->email,
                'gender' => Request()->gender,
                'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'postal_code' => Request()->postal_code,
                'city' => Request()->city,
                'district' => Request()->district,
                'address' => Request()->address,
                'status' => 'active',
                'is_verified' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $this->CustomersModel->create($dataValidated);

            $details = [
                'sender' => 'Asli Semua',
                'title' => 'Please verify your email',
                'body' => URL::to('registration/verify-account/' . $dataValidated['id'])
            ];

            Mail::to(Request()->email)->send(new RegisterMail($details));

            return response()->json([
                'status' => 201,
                'message' => 'Successfully Registered',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendTokenAccount ($id) {
        $result = $this->verifyAccount($id);
        return $result; // Ini bisa diganti sama direct ke halaman login
    }

    public function verifyAccount ($id) {
        try {
            $isExist = $this->CustomersModel->show($id);
            if (!isset($isExist)) return response()->json([
                'status' => 400,
                'message' => `Your account doesn't registered`,
            ], 400);

            if (isset($isExist->email_verified_at) || $isExist->email_verified_at !== NULL) return response()->json([
                'status' => 200,
                'message' => 'Your account has been verified'
            ]);

            $dataVerification = [
                'email_verified_at' => Carbon::now(),
                'is_verified' => 1
            ];
            $this->CustomersModel->updateUser($id, $dataVerification);

            return response()->json([
                'status' => '200',
                'message' => 'Your account successfully verified'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function forgotPassword() {
        try {
            $isExist = $this->CustomersModel->forgotPassword(Request()->email);
            if (!isset($isExist)) return response()->json([
                'status' => 400,
                'message' => `Your account doesn't registered`,
            ], 400);
            $details = [
                'sender' => 'Asli Semua',
                'title' => 'Reset your Password on Asli Semua',
                'body' => URL::to('customers/forgot-password/' . $isExist->id . '/edit')
            ];

            Mail::to(Request()->email)->send(new ForgotPasswordMail($details));

            return response()->json([
                'status' => 200,
                'message' => 'Link of reset password has been sent to your email',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong'
            ], 500);
        }
    }

    public function editForgotPassword() {
        return 'Ini halaman form forgot password';
    }

    public function index() {
        try {
            $data = $this->CustomersModel->index();

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Fetched',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id) {
        try {
            $data = $this->CustomersModel->show($id);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Fetched',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update($id) {
        try {
            Request()->validate(
                [
                    'name' => 'required|max:50',
                    'email' => 'required|email:rfc,dns',
                    'gender' => 'required|max:10',
                    'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|max:13',
                    'postal_code' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
                    'city' => 'required',
                    'district' => 'required|max:50',
                    'address' => 'required|max:255',
                ]
            );

            $dataValidated = [
                'name' => Request()->name,
                'email' => Request()->email,
                'gender' => Request()->gender,
                'phone_number' => Request()->phone_number,
                'postal_code' => Request()->postal_code,
                'city' => Request()->city,
                'district' => Request()->district,
                'address' => Request()->address,
                'updated_at' => Carbon::now(),
            ];
            $this->CustomersModel->updateUser($id, $dataValidated);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Updated',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus($id) {
        try {
            $data = [
                'status' => Request()->status,
                'updated_at' => Carbon::now(),
            ];
            $this->CustomersModel->updateUser($id, $data);

            return response()->json([
                'status' => 200,
                'message' => 'Status Successfully Updated',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong With Validation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePassword($id) {
        try {
            Request()->validate(
                [
                    'new_password' => 'required|min:6',
                    'confirmed_new_password' => 'required|min:6',
                ]
            );
            if(Request()->new_password == Request()->confirmed_new_password) {
                $dataValidated = [
                    'password' => Hash::make(Request()->new_password)
                ];
                $this->CustomersModel->updateUser($id, $dataValidated);

                return response()->json([
                    'status' => 200,
                    'message' => 'Password Successfully Updated',
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'New Password Does Not Match',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong With Validation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
