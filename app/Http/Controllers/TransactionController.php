<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $result = [
            'result' => 'error',
        ];
        $customer = Customer::find($request->input('customerId', false));
        $amount = $request->input('amount', false);
        if ($customer && is_numeric($amount)) {
            $transaction = new Transaction();
            $transaction->customer_id = $customer->id;
            $transaction->amount = round($amount, 2);
            $transaction->save();
            $result['result'] = 'OK';
            $result['transactionId'] = $transaction->id;
            $result['customerId'] = $transaction->customer->id;
            $result['amount'] = $transaction->amount;
            $result['date'] = $transaction->updated_at;
        }

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $result = [
            'result' => 'error',
        ];
        $transaction = Transaction::find($request->input('transactionId', false));
        $amount = $request->input('amount', false);
        if ($transaction && is_numeric($amount)) {
            $transaction->amount = round($amount, 2);
            $transaction->save();
            $result['result'] = 'OK';
            $result['transactionId'] = $transaction->id;
            $result['customerId'] = $transaction->customer->id;
            $result['amount'] = $transaction->amount;
            $result['date'] = $transaction->updated_at;
        }

        return response()->json($result);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = [
            'result' => 'error',
        ];
        if ($transaction = Transaction::find($id)) {
            $result['result'] = $transaction->delete();
        }

        return response()->json($result);
    }

    /**
     * @param $customerId
     * @param $transactionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($customerId, $transactionId)
    {
        $result = [
            'result' => 'error',
        ];


        if ($transaction = Transaction::find($transactionId)) {
            if ($transaction->customer->id == $customerId) {
                $result['result'] = 'OK';
                $result['transactionId'] = $transaction->id;
                $result['amount'] = $transaction->amount;
                $result['date'] = $transaction->updated_at;
            }
        }

        return response()->json($result);
    }

    /**
     * @param bool $customerId
     * @param bool $amount
     * @param bool $date
     * @param int $offset
     * @param int $limit
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter($customerId = false, $amount = false, $date = false, $offset = 0, $limit = 10)
    {
        $list = Transaction::take($limit)->skip($offset);
        if (is_numeric($customerId)) {
            $list->where('customer_id', $customerId);
        }
        if (is_numeric($amount)) {
            $list->where('amount', $amount);
        }
        if ($date) {
            $list->where('updated_at', $date);
        }
        $result['result'] = $list->get()->toArray();


        return response()->json($result);
    }
}
