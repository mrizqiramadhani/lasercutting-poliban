<?php

namespace App\Models;

use App\Http\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;

    /**
     * Akan mengisi kolom "created_at" dan "updated_at" secara otomatis,
     *
     * @var bool
     */
    public $timestamps = true;
    public $incrementing = false;

    /**
     *
     * @var array
     */
    protected $fillable = [
        'invoice',
        'user_id',
        'total',
        'status_order',
        'payment_at',
        'photo_receipt',
    ];

    protected $table = 'm_transaction';

    public function users()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(TransactionDetailModel::class, 'transaction_id', 'id');
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

        if (!empty($filter['user_id'])) {
            $user->where('user_id', $filter['user_id']);
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
}
