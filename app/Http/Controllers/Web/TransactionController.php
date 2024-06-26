<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Transaction\TransactionHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\CartRequest;
use App\Http\Requests\Transaction\TransactionRequest;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transaction;
    public function __construct()
    {
        $this->transaction = new TransactionHelper();
    }

    public function deleteCart($id)
    {
        $role = $this->transaction->deleteCart($id);

        if (!$role) {
            return response()->failed(['Mohon maaf data cart tidak ada']);
        }

        return response()->json([
            "status" => true,
            "message" => "Cart berhasil dihapus"
        ], 200);
    }
    public function createCart(CartRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['product_id', 'user_id']);
        $cart = $this->transaction->createCart($payload);

        if (!$cart['status']) {
            return response()->failed($cart['error']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product Berhasil Ditambahkan',
            'data' => $cart['data']
        ], 200);
    }

    public function getCart(Request $request)
    {
        $filter = [
            'user_id' => $request->user_id ?? '',
        ];
        $itemPerPage = 100;
        $sort = $request->input('sort', 'id DESC');

        try {
            $cart = $this->transaction->getCart($filter, $itemPerPage, $sort);

            // dd($cart['data']->items());

            // return [
            //     "data" => $cart['data']
            // ];
            return view('user.cart', compact('cart'));
        } catch (\Exception $e) {
            // Handle exception, log error, return error view, etc.
            return view('user.cart')->with('error', $e->getMessage());
        }
    }

    public function payment(TransactionRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload =  $request->only(['status_order', 'photo_receipt', 'cart']);

        if (isset($payload['cart'])) {
            $payload['cart'] = json_decode($payload['cart'], true);
        }


        $transaction = $this->transaction->payment($payload);


        if (!$transaction['status']) {
            return response()->failed($transaction['error']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product Berhasil Ditambahkan',
            'data' => $transaction['data']
        ], 200);
    }

    public function updateStatus(TransactionRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload =  $request->only(['id', 'status_order']);
        $transaction = $this->transaction->updateStatus($payload, $payload['id'] ?? 0);

        if (!$transaction['status']) {
            return response()->failed($transaction['error']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Status Berhasil Diubah',
            'data' => $transaction['data']
        ], 200);
    }



    public function getTransaction(Request $request)
    {
        $filter = [
            'name' => $request->input('name', ''),
        ];
        $itemPerPage = 100;
        $sort = $request->input('sort', 'id DESC');


        try {
            $transaction = $this->transaction->getTransaction($filter, $itemPerPage, $sort);


            return view('admin.order', compact('transaction'));
        } catch (\Exception $e) {
            return view('admin.order')->with('error', $e->getMessage());
        }
    }

    public function showTransaction(Request $request)
    {
        $filter = [
            'user_id' => $request->user_id ?? '',
        ];
        $itemPerPage = 100;
        $sort = $request->input('sort', 'id DESC');


        try {
            $transaction = $this->transaction->getTransaction($filter, $itemPerPage, $sort);
            return view('user.order', compact('transaction'));
        } catch (\Exception $e) {
            // Handle exception, log error, return error view, etc.
            return view('user.order')->with('error', $e->getMessage());
        }
    }
}
