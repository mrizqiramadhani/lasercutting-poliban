<?php

namespace App\Http\Controllers\Web;

use App\Helpers\User\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new UserHelper();
    }

    /**
     * Delete data user
     *
     */
    public function destroy($id)
    {
        $user = $this->user->delete($id);

        if (!$user) {
            return response()->failed(['Mohon maaf data pengguna tidak ditemukan']);
        }

        return response()->success($user, "User berhasil dihapus");
    }

    public function index(Request $request)
    {
        $filter = [
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
        ];
        $users = $this->user->getAll($filter, 5, $request->sort ?? '');

        return view('admin.products', compact('users'));
    }


    public function show($id)
    {
        $user = $this->user->getById($id);

        // dd($user['data']->name);
        try {

            if (request()->route()->named('profile.setting.user')) {
                return view('user.profile', compact('user'));
            } elseif (request()->route()->named('profile.setting.admin')) {
                return view('admin.profile', compact('user'));
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            // Handle exception, log error, return error view, etc.
            return view('admin.beranda-admin' || 'admin.beranda-user')->with('error', $e->getMessage());
        }
    }


    public function store(UserRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/CreateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['email', 'name', 'phone_number', 'address', 'photo', 'password', 'role']);
        $user = $this->user->create($payload);

        if (!$user['status']) {
            return response()->failed($user['error']);
        }

        return response()->json([
            'message' => 'User Berhasil Ditambahkan',
            'data' => $user['data']
        ], 200);
    }

    /**
     * Mengubah data user di tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function update(UserRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/UpdateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['id', 'email', 'name', 'phone_number', 'address', 'photo', 'role']);
        $user = $this->user->update($payload, $payload['id'] ?? 0);


        if (!$user['status']) {
            return response()->failed($user['error']);
        }

        return response()->json([
            'status' => true,
            'message' => 'User Berhasil Diubah',
            'data' => $user['data']
        ], 200);
    }
}
