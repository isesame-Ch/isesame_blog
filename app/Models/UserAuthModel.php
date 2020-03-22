<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class UserAuthModel extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail,SoftDeletes;

    protected $table = 'user_auth';

    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    public $hidden = [
        'remember_token'
    ];

    /**
     * 账户信息
     */
    public function userInfo()
    {
        return $this->hasOne(UserModel::class, 'id','user_id');
    }

    /**
     * 管理员
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(AdminModel::class,'user_id', 'user_id');
    }

    /**
     * 判断用户名是否存在
     * @param $username
     * @param int $identity_type
     * @return mixed
     */
    public static function isUserNameExists($username, $identity_type = 1)
    {
        return self::query()->withTrashed()->where(['identifier'=>$username,'identity_type' => $identity_type])->exists();
    }
}
