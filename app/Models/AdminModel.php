<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminModel extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'admin';

    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 不可以被批量赋值的属性。
     * @var array
     */
    #protected $guarded = [''];

    /**
     * 可以被批量赋值的属性。
     * @var array
     */
    protected $fillable = ['identity'];

    /**
     * 管理员账户信息
     */
    public function userInfo()
    {
        return $this->hasOne(UserModel::class, 'id','user_id');
    }

    /**
     * 管理员账户
     */
    public function userAuthInfo()
    {
        return $this->hasMany(UserAuthModel::class, 'user_id','user_id');
    }

    /**
     * @param array $where
     * @param bool $pageSize
     * @param array $columns
     * @param bool $or
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Authenticatable[]
     */
    public static function getList($where = [], $pageSize = false, $columns = ['*'], $or = false)
    {
        $query = self::query()
            ->with(['userInfo'])
            ->leftJoin('user_auth','admin.user_id','user_auth.user_id')
            ->select($columns)
            ->where(function ($model) use ($where, $or) {
                foreach ($where as $field => $value) {
                    if ($value instanceof \Closure) {
                        $model = (!$or)
                            ? $model->where($value)
                            : $model->orWhere($value);
                    } elseif (is_array($value)) {
                        if (count($value) === 3) {
                            list($field, $operator, $search) = $value;
                            $model = (!$or)
                                ? $model->where($field, $operator, $search)
                                : $model->orWhere($field, $operator, $search);
                        } elseif (count($value) === 2) {
                            list($field, $search) = $value;
                            $model = (!$or)
                                ? $model->where($field, '=', $search)
                                : $model->orWhere($field, '=', $search);
                        }
                    } else {
                        $model = (!$or)
                            ? $model->where($field, '=', $value)
                            : $model->orWhere($field, '=', $value);
                    }

                }
            });

        return $pageSize ? $query->paginate($pageSize) : $query->get();
    }
}
