<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Helpers\Angular;

class AppController extends Controller
{
    /**
     * Our custom service provider is going to make sure
     * $ng is a singleton
     */
    public function index()
    {
        // Provide our service's assets as $ngAssets inside
        // of app.blade.php
        return view('beranda');
    }

    public function log()
    {
        // Provide our service's assets as $ngAssets inside
        // of app.blade.php
        return view('welcome');
    }
}
