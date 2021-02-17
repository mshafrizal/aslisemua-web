<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\CustomersModel;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Registered',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Something Went Wrong',
                'error' => $e
            ]);
        }
    }

    public function index() {
        try {
            $data = $this->CustomersModel->index();

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Fetched',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e
            ]);
        }
    }

    public function show($id) {
        try {
            $data = $this->CustomersModel->show($id);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Fetched',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e
            ]);
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
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Something Went Wrong',
                'error' => $e
            ]);
        }
    }

    public function updateStatus($id) {
        try {
            $data = [
                'status' => 'inactive',
                'updated_at' => Carbon::now(),
            ];
            $this->CustomersModel->updateUser($id, $data);

            return response()->json([
                'status' => 200,
                'message' => 'Status Successfully Updated',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Something Went Wrong With Validation',
                'error' => $e
            ]);
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
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'New Password Does Not Macth',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Something Went Wrong With Validation',
                'error' => $e
            ]);
        }
    }
}
