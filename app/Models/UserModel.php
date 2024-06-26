<?php
namespace App\Models;

use App\Http\Traits\Uuid;
use App\Repository\CrudInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements CrudInterface, JWTSubject
{
    use HasFactory;
    use SoftDeletes; // Use SoftDeletes library
    use Uuid;

    /**
     * Akan mengisi kolom "created_at" dan "updated_at" secara otomatis,
     *
     * @var bool
     */
    public $timestamps = true;
    public $incrementing = false;

    /**
     * Menentukan kolom apa saja yang bisa dimanipulasi oleh UserModel
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'address',
        'password',
        'phone_number',
        'photo',
        'role_id',
    ];

    /**
     * Menentukan nama tabel yang terhubung dengan Class ini
     *
     * @var string
     */
    protected $table = 'm_user';

    public function carts()
    {
        return $this->hasMany(CartModel::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'id');
    }

    public function drop(string $id)
    {
        return $this->find($id)->delete();
    }

    public function edit(array $payload, string $id)
    {
        return $this->find($id)->update($payload);
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $user = $this->query();

        if (!empty($filter['name'])) {
            $user->where('name', 'LIKE', '%' . $filter['name'] . '%');
        }

        if (!empty($filter['email'])) {
            $user->where('email', 'LIKE', '%' . $filter['email'] . '%');
        }

        $sort = $sort ?: 'id DESC';
        $user->orderByRaw($sort);
        $itemPerPage = ($itemPerPage > 0) ? $itemPerPage : false;

        return $user->paginate($itemPerPage)->appends('sort', $sort);
    }

    public function getById(string $id)
    {
        return $this->find($id);
    }

    public function store(array $payload)
    {
        return $this->create($payload);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'user' => [
                'id' => $this->id,
                'email' => $this->email,
            ]
        ];
    }

    public function isHasRole($permissionName)
    {
        $tokenPermission = explode('|', $permissionName);
        $userPrivilege = json_decode($this->role ?? '{}', TRUE);

        foreach ($tokenPermission as $val) {
            $permission = explode('.', $val);
            $feature = $permission[0] ?? '-';
            $activity = $permission[1] ?? '-';
            if (isset($userPrivilege[$feature][$activity]) && $userPrivilege[$feature][$activity] === true) {
                return true;
            }
        }

        return false;
    }
}
