<?php

use App\Http\Controllers\Web\AppController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\TestsController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\TransactionController;
use App\Http\Controllers\Web\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/log', [AppController::class, 'log'])->name('log');

//auth
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//product
Route::get('/product', [ProductController::class, 'index'])->name('get.product')
    ->middleware((['auth.api']));
Route::post('/product', [ProductController::class, 'store'])->name('create.product');
Route::put('/product', [ProductController::class, 'update'])->name('update.product');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('delete.product');
// ->middleware((['auth.api', 'role:user']));
Route::get('/product/{id}', [ProductController::class, 'show'])->name('detail.product');

//role
Route::get('/role', [RoleController::class, 'index'])->name('get.role');
Route::get('/role/{id}', [RoleController::class, 'show'])->name('detail.role');
Route::post('/role', [RoleController::class, 'store'])->name('create.role');
Route::put('/role', [RoleController::class, 'update'])->name('update.role');
Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('delete.role');

//user
Route::get('/user', [UserController::class, 'index'])->name('get.user');
// Route::get('/user/{id}', [UserController::class, 'show'])->name('detail.user');
Route::post('/user', [UserController::class, 'store'])->name('create.user');
Route::put('/user', [UserController::class, 'update'])->name('update.user');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('delete.user');

//transaction
Route::delete('/cart/{id}', [TransactionController::class, 'deleteCart'])->name('delete.cart');
Route::post('/cart', [TransactionController::class, 'createCart'])->name('create.cart');
Route::get('/cart', [TransactionController::class, 'getCart'])->name('get.cart');
// ->middleware((['auth.api']));
Route::get('/transactions', [TransactionController::class, 'showTransaction'])->name('show.transaction');
Route::post('/payment', [TransactionController::class, 'payment'])->name('payment');
Route::put('/transaction', [TransactionController::class, 'updateStatus'])->name('update.status');
Route::get('/transaction-admin', [TransactionController::class, 'getTransaction'])->name('get.transaction');

Route::get('/transaction', [TransactionController::class, 'showTransaction'])->name('show.transaction');

Route::get('/', [AppController::class, 'index'])->name('beranda');

Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');
Route::get('/kontak-admin', function () {
    return view('admin.kontak');
})->name('kontak-admin');
Route::get('/kontak-user', function () {
    return view('user.kontak');
})->name('kontak-user');
// ->middleware((['auth.api']));

Route::get('/Tentang-kami', function () {
    return view('Tentang-kami');
})->name('tentang-kami');
Route::get('/tentang-kami-admin', function () {
    return view('admin.tentang-kami');
})->name('tentang-kami-admin');
Route::get('/tentang-kami-user', function () {
    return view('user.tentang-kami');
})->name('tentang-kami-user');

Route::get('/profiles/{id}', [UserController::class, 'show'])->name('profile.setting.user');
Route::get('/profile/{id}', [UserController::class, 'show'])->name('profile.setting.admin');


Route::get('/dashboard', [ProductController::class, 'index'])->name('beranda.user');
Route::get('/admin', [ProductController::class, 'index'])->name('admin.beranda-admin');
