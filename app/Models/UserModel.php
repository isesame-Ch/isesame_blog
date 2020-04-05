<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class UserModel extends BaseModel
{
    use SoftDeletes;
    protected $table = 'user';

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
    protected $guarded = [''];

    /**
     * 可以被批量赋值的属性。
     * @var array
     */
    protected $fillable = [
        'nickname','email','mobile','updated_at'
    ];

    protected $hidden = [
        //remember_token 字段用于记住我的功能
        'remember_token',
    ];

    /**
     * 管理员
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin()
    {
        return $this->hasOne(AdminModel::class,'user_id', 'id');
    }

    /**
     * 账号
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAuth()
    {
        return $this->hasMany(UserAuthModel::class,'user_id', 'id');
    }

    /**
     * 昵称是否已存在
     * @param $nickName
     * @return mixed
     */
    public static function isNickNameExists($nickName)
    {
        return self::query()->withTrashed()->Where('nickname', $nickName)->exists();
    }

    /**
     * 邮箱是否已绑定
     * @param $email
     * @return bool
     */
    public static function isEmailBinded($email)
    {
        return self::query()->where('email', $email)->exists();
    }

    /**
     * 手机号是否已绑定
     * @param $mobile
     * @return bool
     */
    public static function isMobileBinded($mobile)
    {
        return self::query()->where('mobile', $mobile)->exists();
    }

    public static function getList($where = [], $pageSize = false, $columns = ['*'], $or = false)
    {
        $query = self::query()
            ->with(['userAuth'])
            ->leftJoin('user_auth', 'user_auth.user_id', 'user.id')
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
