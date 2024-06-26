<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Role\RoleHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $role;
    public function __construct() {
        $this->role = new RoleHelper();
    }

    public function destroy($id)
    {
        $role = $this->role->delete($id);

        if (!$role) {
            return response()->failed(['Mohon maaf data role tidak ada']);
        }

        return response()->json([
            "message" => "Role berhasil dihapus"
        ],200);

    }

    public function index(Request $request)
    {
        $filter = [
            'name' => $request->input('name', '')
        ];

        $itemPerPage = 100;
        $sort = $request->input('sort', 'id DESC');

        $role = $this->role->getAll($filter,$itemPerPage,$sort);

        return view('admin.products',compact('role'));
    }

    public function show($id)
    {
        $role = $this->role->getById($id);

        if (!($role['status'])) {
            return response()->failed(['Data role tidak ditemukan'], 404);
        }

        return view('admin.products', compact('role'));
    }

    public function store(RoleRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['name']);
        $role = $this->role->create($payload);

        if (!$role['status']) {
            return response()->failed($role['error']);
        }

        return response()->json([
            'message' => 'Role Berhasil Ditambahkan',
            'data' => $role['data']
        ], 200);
    }


    public function update(RoleRequest $request)
    {

        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['name','id']);
        $role = $this->role->update($payload, $payload['id'] ?? 0);

        if (!$role['status']) {
            return response()->failed($role['error']);
        }

        return response()->json([
            'message' => 'Role Berhasil Diubah',
            'data' => $role['data']
        ], 200);
    }
}
