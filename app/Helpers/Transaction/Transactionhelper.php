<?php

namespace App\Helpers\Transaction;

use App\Helpers\Custom;
use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\TransactionDetailModel;
use App\Models\TransactionModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;
use Ramsey\Uuid\Uuid as Generator;

class TransactionHelper extends Custom
{
    const PAYMENT_PHOTO_DIRECTORY = 'payment-img';
    private $cartModel;
    private $transactionModel;
    private $transactionDetailModel;
    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }
    public function createCart(array $payload): array
    {
        try {

            $existingCartItem = $this->cartModel
            ->where('product_id', $payload['product_id'])
            ->where('user_id', $payload['user_id'])
            ->first();

                if ($existingCartItem) {
                    return [
                        'status' => false,
                        'error' => 'Silahkan selesaikan pesanan anda dulu',
                    ];
                }


            $cart = $this->cartModel->store($payload);

            return [
                'status' => true,
                'data' => $cart
            ];
        } catch (Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    public function getCart(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $cart = $this->cartModel->getAll($filter, $itemPerPage, $sort);

        return [
            'status' => true,
            'data' => $cart
        ];
    }

    public function deleteCart(string $id): bool
    {
        try {
            $this->cartModel->drop($id);

            return true;
        } catch (Throwable $th) {
            return false;
        }
    }

    public function payment(array $payload): array
    {
        $currenDate = Carbon::now();

        try {
            DB::beginTransaction();

            $payload = $this->uploadGetPayload($payload);

            if (empty($payload['cart'])) {
                return [
                    'status' => false,
                    'error' => 'No cart provided',
                ];
            }


            $firstCart = $this->cartModel->with('user')->find($payload['cart'][0]['id']);
            if (!$firstCart) {
                return [
                    'status' => false,
                    'error' => 'Cart not found',
                ];
            }
            $userId = $firstCart->user->id;

            $transactionId = Generator::uuid4()->toString();

            $formattedDate = Carbon::now()->format('d-m-Y');

            $transactionData = [
                    'id' => $transactionId,
                    'invoice' => 'INV|' . $formattedDate,
                    'user_id' => $userId,
                    'total' => 0,
                    'status_order' => $payload['status_order'],
                    'payment_at' => $currenDate,
                    'photo_receipt' => $payload['photo_receipt'],
            ];

            $totalTransaction = 0;

            foreach ($payload['cart'] as $item) {
                $cartId = $item['id'];
                $quantity = $item['stock'];

                $cart = $this->cartModel->find($cartId);

                if (!$cart) {
                    return [
                        'status' => false,
                        'error' => 'cart not found',
                    ];
                }

                $product = $cart->product;

                if (!$product) {
                    return [
                        'status' => false,
                        'error' => 'Product not found',
                    ];
                }


                if ($product->stock < $quantity) {
                    return [
                        'status' => false,
                        'error' => 'Invalid stock',
                    ];
                }


                $product->stock -= $quantity;
                $product->save();

                $subtotal = $product->price * $quantity;

                $totalTransaction += $subtotal;

                $this->transactionDetailModel->create([
                    'transaction_id' => $transactionId,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'sub_total' => $subtotal,
                    'price' => $product->price
                ]);
            }

            $transactionData['total'] = $totalTransaction;


            $transaction = $this->transactionModel->store($transactionData);


            $cartIds = collect($payload['cart'])->pluck('id')->toArray();

            $this->cartModel->whereIn('id', $cartIds)->delete();


            DB::commit();

            return [
                'status' => true,
                'data' => $transaction,
            ];
        } catch (Throwable $th) {
            DB::rollBack();

            return [
                'status' => false,
                'error' => $th->getMessage(),
            ];
        }
    }

    public function updateStatus(array $payload, string $id): array
    {
        try {
            $this->transactionModel->edit($payload, $id);

            $transaction = $this->transactionModel->getById($id);

            return [
                'status' => true,
                'data' => $transaction['data']
            ];
        } catch (Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    private function uploadGetPayload(array $payload)
    {

        if (!empty($payload['photo_receipt'])) {
            $fileName = $this->generateFileName($payload['photo_receipt'], 'USER_' . date('Ymdhis'));
            $photo = $payload['photo_receipt']->storeAs(self::PAYMENT_PHOTO_DIRECTORY, $fileName, 'public');
            $payload['photo_receipt'] = $photo;
        } else {
            unset($payload['photo_receipt']);
        }

        return $payload;
    }

    public function getTransaction(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $products = $this->transactionModel->getAll($filter, $itemPerPage, $sort);

        return [
            'status' => true,
            'data' => $products
        ];
    }
}
