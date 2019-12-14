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

    public static function isUserNameExists($userName, $nickName)
    {
        return self::query()->where('username', $userName)->orWhere('nickname', $nickName)->exists();
    }

    public static function isEmailBinded($email)
    {
        return self::query()->where('email', $email)->exists();
    }
}
