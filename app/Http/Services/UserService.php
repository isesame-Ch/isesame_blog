<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2019/12/14
 * Time: 2:13
 */

namespace App\Http\Services;


use App\Models\UserModel;

class UserService extends BaseService
{
    /**
     * 根据用户名获取用户信息
     * @param $username
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function getByUserName($username)
    {
        $user = UserModel::query()->where('username', $username)->first();

        return $user;
    }
}