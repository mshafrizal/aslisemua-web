<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\CustomersModel;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;

class CustomersController extends Controller
{
    public function __construct(){
        $this->CustomersModel = new CustomersModel();
    }

    public function create() {
        Request()->validate(
            [
                'name' => 'required|max:50',
                'email' => 'required|email:rfc,dns|unique:customers',
                'gender' => 'required|max:10',
                'password' => 'required',
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

        try {
            $this->CustomersModel->create($dataValidated);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Registered',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'error' => $e
            ]);
        }
    }

    public function index() {
        $data = $this->CustomersModel->index();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully Fetched',
            'data' => $data
        ]);
    }

    public function show($id) {
        $data = $this->CustomersModel->show($id);

        return response()->json([
            'status' => 200,
            'message' => 'Successfully Fetched',
            'data' => $data
        ]);
    }

    public function update($id) {
        Request()->validate(
            [
                'name' => 'required|max:50',
                'email' => 'required|email:rfc,dns',
                'gender' => 'required|max:10',
                'password' => 'required',
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
            'password' => Hash::make(Request()->password),
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
    }

    public function updateStatus($id) {
        $data = [
            'status' => 'inactive',
            'updated_at' => Carbon::now(),
        ];

        $this->CustomersModel->updateUser($id, $data);

        return response()->json([
            'status' => 200,
            'message' => 'Status Successfully Updated',
        ]);
    }
}
