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
            $result['date'] = $transaction->updated_at->format(config('app.date_format'));
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
            $result['date'] = $transaction->updated_at->format(config('app.date_format'));
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
                $result['date'] = $transaction->updated_at->format(config('app.date_format'));
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
    public function filter($customerId = 0, $amount = 0, $date = '', $offset = 0, $limit = 5)
    {
        $result['result'] = [];
        $page = round($offset / $limit) + 1;
        $list = Transaction::when($customerId && $customerId !== 'false', function($query) use ($customerId) {
                return $query->where('customer_id', $customerId);
            })
            ->when(is_numeric($amount) && $amount !== 'false', function($query) use ($amount) {
                return $query->where('amount', $amount);
            })
            ->when($date && $date !== 'false', function($query) use ($date) {
                return $query->where('updated_at', $date);
            })
            ->paginate($limit, ['*'], 'page', $page)
        ;

        $result['total'] = $list->total();
        $result['current_page'] = $list->currentPage();
        $result['last_page'] = $list->lastPage();

        foreach ($list as $item) {
            $result['result'][] = [
                'id'         => $item->id,
                'customerId' => $item->customer->id,
                'amount'     => $item->amount,
                'date'       => $item->updated_at->format(config('app.date_format')),
            ];
        }

        return response()->json($result);
    }
}
