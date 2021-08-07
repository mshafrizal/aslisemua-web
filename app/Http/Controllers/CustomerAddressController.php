<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\CustomersModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CustomerAddressController extends Controller
{
    function getCustomerAddressesByCustomerId($customerId) {
        try {
            $data = CustomerAddress::where('customer_id', $customerId)->get();
            if (count($data)) return response()->json([
                'status' => 200,
                'message' => 'Successfully Fetched',
                'results' => $data
            ], 200);

            return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getCustomerAddress($id) {
        try {
            $data = CustomerAddress::find($id);
            if ($data) return response()->json([
                'status' => 200,
                'message' => 'Successfully Fetched',
                'results' => $data
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function createCustomerAddress(Request $request) {
        try {
            Request()->validate(
                [
                    'name' => 'required|max:50',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|max:13',
                    'address' => 'required|max:255',
                ]
            );

            $customer = CustomersModel::where('id', $request->customer_id)->first();

            if (empty($customer)) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => (Object)[]
            ]);

            $newCustomerAddress = new CustomerAddress([
                'id' => Str::uuid(),
                'customer_id' => $customer->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'is_default' => false,
                'address' => $request->address
            ]);

            if ($newCustomerAddress->save()) return response()->json([
                'status' => 201,
                'message' => 'New address successfully created'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Error',
                'error' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function updateCustomerAddress(Request $request, $customerId, $addressId) {
        try {
            Request()->validate(
                [
                    'name' => 'required|max:50',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|max:13',
                    'address' => 'required|max:255',
                ]
            );

            $customer = CustomersModel::where('id', $customerId)->first();

            if (empty($customer)) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => (Object)[]
            ]);

            $customerAddress = CustomerAddress::where('id', $addressId)->first();
            if (empty($customerAddress)) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => (Object)[]
            ]);
            
            CustomerAddress::where('customer_id', $customerId)->where('id', $addressId)->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Address successfully updated'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Error',
                'error' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function deleteCustomerAddress($customerId, $addressId) {
        try {
            CustomerAddress::where('customer_id', $customerId)->where('id', $addressId)->delete();
            $addresses = CustomerAddress::where('customer_id', $customerId)->get();
            if (count($addresses)) CustomerAddress::where('id', $addresses[0]->id)->update(['is_default' => true]);            
            return response()->json([
                'status' => 200,
                'message' => 'Address has been deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function setCustomerAddressDefault(Request $request) {
        try {
            $customer = CustomersModel::where('id', $request->customer_id)->first();
            if (empty($customer)) return response()->json([
                'status' => 200,
                'message' => 'Customer does not found',
                'results' => (Object)[]
            ]);

            $address = CustomerAddress::where('customer_id', $request->customer_id)->get();
            if (count($address) === 0) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);

            foreach ($address as $objValue) {
                if ($objValue->id === $request->address_id) CustomerAddress::where('id', $request->address_id)->update(['is_default' => true]);
                else CustomerAddress::where('id', $objValue->id)->update(['is_default' => false]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Address successfully selected'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
