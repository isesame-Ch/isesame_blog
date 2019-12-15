<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class UserModel extends Authenticatable
{
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
    #protected $guarded = [''];

    /**
     * 可以被批量赋值的属性。
     * @var array
     */
    protected $fillable = [
        'username', 'password',''
    ];
       
    protected $hidden = [ 
        //remember_token 字段用于记住我的功能
        'password', 'remember_token',
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
     * 用户名是否存在
     * @param $userName
     * @param $nickName
     * @return bool
     */
    public static function isUserNameExists($userName, $nickName)
    {
        return self::query()->where('username', $userName)->orWhere('nickname', $nickName)->exists();
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
}
