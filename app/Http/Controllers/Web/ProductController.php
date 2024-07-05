<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Product\ProductHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product;

    public function __construct()
    {
        $this->product = new ProductHelper();
    }

    public function destroy($id)
    {

        try {
            // Retrieve the product by ID
            $product = $this->product->delete($id);
            if (!$product) {
                return response()->failed(['Mohon maaf data product tidak ditemukan']);
            }

            return response()->json([
                "status" => true,
                "message" => "Product Berhasil dihapus"
            ], 200);
            // Pass the product to the view
            // return view('admin.hapus', ['item' => $product]);
        } catch (\Exception $e) {
            // Handle exception, log error, return error view, etc.
            return view('admin.hapus')->with('error', $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        $filter = [
            'name' => $request->input('name', ''),
        ];
        $itemPerPage = 100;
        $sort = $request->input('sort', 'id DESC');


        try {
            $products = $this->product->getAll($filter, $itemPerPage, $sort);
            $user = auth()->user();
            // dd($user);

            if (request()->route()->named('admin.beranda-admin')) {
                return view('admin.beranda-admin', compact('products'));
            } elseif (request()->route()->named('beranda.user')) {
                return view('user.beranda-user', compact('products'));
            } elseif (request()->route()->named('beranda')) {
                return view('beranda', compact('products'));
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            // Handle exception, log error, return error view, etc.
            return view('admin.beranda-admin' || 'user.beranda-user')->with('error', $e->getMessage());
        }
    }


    public function show($id)
    {
        $product = $this->product->getById($id);

        if (!($product['status'])) {
            return response()->failed(['Data product tidak ditemukan'], 404);
        }



        return view('admin.products', compact('product'));
    }

    public function store(ProductRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['name', 'stock', 'description', 'photo', 'price']);
        $product = $this->product->create($payload);


        if (!$product['status']) {
            return response()->failed($product['error']);
        }


        return response()->json([
            'status' => true,
            'message' => 'Product Berhasil Ditambahkan',
            'data' => $product['data']
        ], 200);
    }


    public function update(ProductRequest $request)
    {

        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['name', 'stock', 'description', 'id', 'photo']);
        $product = $this->product->update($payload, $payload['id'] ?? 0);

        if (!$product['status']) {
            return response()->failed($product['error']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product Berhasil Ditambahkan',
            'data' => $product['data']
        ], 200);
    }
}
