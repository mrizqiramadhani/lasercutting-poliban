<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Helpers\Angular;
use App\Helpers\Product\ProductHelper;
use App\Http\Requests\Product\ProductRequest;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Our custom service provider is going to make sure
     * $ng is a singleton
     */
    private $product;

    public function __construct()
    {
        $this->product = new ProductHelper();
    }


    public function index(Request $request)
    {

        $filter = [
            'name' => $request->input('name', ''),
        ];
        $itemPerPage = 100;
        $sort = $request->input('sort', 'id DESC');


            $products = $this->product->getAll($filter, $itemPerPage, $sort);

                return view('beranda', compact('products'));
    }

    public function log()
    {
        // Provide our service's assets as $ngAssets inside
        // of app.blade.php
        return view('welcome');
    }
}
