<?php

namespace App\Helpers\User;

use App\Helpers\Custom;
use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthHelper extends Custom
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register(array $payload): array
    {
        try {

            if ($payload['password'] !== $payload['confirm_password']) {
                return response()->failed(['Password tidak sama'], 400);
            }

            $payload['password'] = Hash::make($payload['password']);
            $role = RoleModel::where('name', 'user')->first();
            if (!$role) {
                return response()->failed(['Tambahkan role terlebih dahulu'], 404);
            }


            $payload['role_id'] = $role->id;

            $user = $this->userModel->store($payload);

            return [
                'status' => true,
                'data' => $user
            ];
        } catch (Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    public static function login($email, $password)
    {
        try {

            $user = UserModel::where('email', $email)->first();

            if (!$user) {
                return [
                    'status' => false,
                    'error' => ["Email tidak terdaftar"]
                ];
            }

            $credentials = ['email' => $email, 'password' => $password];

            if (!$token = JWTAuth::attempt($credentials)) {
                return [
                    'status' => false,
                    'error' => ["Kombinasi email dan password yang Anda masukkan salah"]
                ];
            }
        } catch (JWTException $e) {
            return [
                'status' => false,
                'error' => ["Could not create token."]
            ];
        }

        return [
            'status' => true,
            'data' => [
                'token' => $token,
                'type' => 'bearer',
                'id' => $user->id,
                'name' => $user->name,
                'role_id' => $user->role_id,
                'role_name' => $user->role->name ?? null
            ]
        ];
    }

    public static function logout($token)
    {
        try {
            JWTAuth::invalidate($token);
            return [
                'status' => true,
                'message' => 'Logout successful'
            ];
        } catch (JWTException $e) {
            return [
                'status' => false,
                'error' => 'Failed to invalidate token'
            ];
        }
    }
}
