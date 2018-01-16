<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $result = [
            'result' => 'error'
        ];
        $customerName = $request->input('name', false);
        $customerCNP = $request->input('cnp', false);
        if ($customerName && $customerCNP) {
            $customer = new Customer();
            $customer->name = $customerName;
            $customer->cnp = $customerCNP;
            $customer->save();
            $result['result'] = $customer->id;
        }

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $result['result'] = Customer::all();

        return response()->json($result);
    }
}
