<?php

namespace App\Helpers\Product;

use App\Helpers\Custom;
use App\Models\CartModel;
use App\Models\ProductModel;
use Illuminate\Support\Facades\DB;
use Throwable;


class ProductHelper extends Custom
{
    const PRODUCT_PHOTO_DIRECTORY = 'product-img';
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function create(array $payload): array
    {
        try {
            $payload = $this->uploadGetPayload($payload);
            $product = $this->productModel->store($payload);

            return [
                'status' => true,
                'data' => $product
            ];
        } catch (Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    public function delete(string $id): bool
    {
        DB::beginTransaction();

    try {
        // Hapus produk
        $this->productModel->drop($id);

        // Hapus entri keranjang yang memiliki product_id yang sama
        CartModel::where('product_id', $id)->delete();

        DB::commit();

        return true;
    } catch (Throwable $th) {
        DB::rollBack();

        return false;
    }
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $products = $this->productModel->getAll($filter, $itemPerPage, $sort);

        return [
            'status' => true,
            'data' => $products
        ];
    }


    public function getById(string $id): array
    {
        $product = $this->productModel->getById($id);
        if (empty($product)) {
            return [
                'status' => false,
                'data' => null
            ];
        }

        return [
            'status' => true,
            'data' => $product
        ];
    }

    public function update(array $payload, string $id): array
    {
        try {

            $payload = $this->uploadGetPayload($payload);
            $this->productModel->edit($payload, $id);

            $product = $this->getById($id);

            return [
                'status' => true,
                'data' => $product['data']
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
        if (!empty($payload['photo'])) {
            $fileName = $this->generateFileName($payload['photo'], 'PODUCT_' . date('Ymdhis'));
            $photo = $payload['photo']->storeAs(self::PRODUCT_PHOTO_DIRECTORY, $fileName, 'public');
            $payload['photo'] = $photo;
        } else {
            unset($payload['photo']);
        }

        return $payload;
    }
}
