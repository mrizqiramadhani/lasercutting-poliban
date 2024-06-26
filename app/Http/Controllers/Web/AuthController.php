<?php

namespace App\Http\Controllers\Web;

use App\Helpers\User\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\UserModel;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $auth;
    private $user;

    public function __construct()
    {
        $this->auth = new AuthHelper();
        $this->user = new UserModel();
    }

    public function loginPage()
    {
        return view("login");
    }
    public function registerPage()
    {
        return view("register");
    }

    public function register(RegisterRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['email', 'name', 'password', 'confirm_password', 'role_id']);
        $auth = $this->auth->register($payload);

        if (!$auth['status']) {
            return response()->json(['error' => $auth['error']], 400);
        }

        return response()->json(['success' => 'Registrasi Berhasil'], 200);
    }

    public function login(LoginRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');
        $login = AuthHelper::login($credentials['email'], $credentials['password']);

        if (!$login['status']) {
            return response()->json($login['error'], 422);
        }

        $user = $login['data'];

        $this->user->role()->first();

        return response()->json([
            'success' => 'Login Berhasil',
            "data" => $user
        ], 200);
    }
}
