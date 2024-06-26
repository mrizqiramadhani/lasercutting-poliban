<?php
namespace App\Helpers\User;

use App\Helpers\Custom;
use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserHelper extends Custom
{
    const USER_PHOTO_DIRECTORY = 'user-img';
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function create(array $payload): array
    {
        try {
            $payload['password'] = Hash::make($payload['password']);

            $payload = $this->uploadGetPayload($payload);

            $role = RoleModel::where('name', $payload['role'])->first();
            if(!$role) {
                return response()->failed(['Tambahkan role terlebih dahulu'],404);
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


    public function delete(string $id): bool
    {
        try {
            $this->userModel->drop($id);

            return true;
        } catch (Throwable $th) {
            return false;
        }
    }


    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $users = $this->userModel->getAll($filter, $itemPerPage, $sort);

        return [
            'status' => true,
            'data' => $users
        ];
    }


    public function getById(string $id): array
    {
        $user = $this->userModel->getById($id);
        if (empty($user)) {
            return [
                'status' => false,
                'data' => null
            ];
        }

        return [
            'status' => true,
            'data' => $user
        ];
    }


    public function update(array $payload, string $id): array
    {
        try {

            $role = RoleModel::where('name', $payload['role'])->first();
            if(!$role) {
                return [
                    'status' => false,
                    'error' => 'Tambahkan role terlebih dahulu',
                ];
            }

            $payload['role_id'] = $role->id;

            $payload = $this->uploadGetPayload($payload);
            $this->userModel->edit($payload, $id);

            $user = $this->getById($id);

            return [
                'status' => true,
                'data' => $user['data']
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
            $fileName = $this->generateFileName($payload['photo'], 'USER_' . date('Ymdhis'));
            $photo = $payload['photo']->storeAs(self::USER_PHOTO_DIRECTORY, $fileName, 'public');
            $payload['photo'] = $photo;
        } else {
            unset($payload['photo']);
        }

        return $payload;
    }
}
