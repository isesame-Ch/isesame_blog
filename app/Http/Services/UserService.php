<?php
/**
 * Created by PhpStorm.
 * User: 79834
 * Date: 2019/12/14
 * Time: 2:13
 */

namespace App\Http\Services;


use App\Helpers\ErrorCode;
use App\Models\UserAuthModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;

class UserService extends BaseService
{
    /**
     * 根据用户名获取用户信息
     * @param $username
     * @param int $identity_type
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function getByUserName($username, $identity_type = 1)
    {
        $userAuth = UserAuthModel::query()->where(['identifier'=> $username,'identity_type' => $identity_type])->with(['userInfo'])->first();
        return $userAuth;
    }

    /**
     * @param $data
     * @return bool
     * 自动注册用户
     */
    public function autoRegisterUser($data)
    {
        $username = isset($data['username']) ? $data['username'] : 'user'.time().rand(0,9999);
        $password = isset($data['password']) ? $data['password'] : 'pwd1234';
        $nickname = isset($data['nickname']) ? $data['nickname'] : 'nickname'.time().rand(0,9999);
        $email = isset($data['email']) ? $data['email'] : '';

        $user = new UserModel();
        $user->username = $username;
        $user->password = md5($password);
        $user->nickname = $nickname;
        $user->email = $email;
        $user->created_at = time();
        $result = $user->save();

        return $result;
    }

    /**
     * 用户登录
     * @param $data
     * @param int $type
     * @return mixed
     * @throws \Exception
     */
    public function login($data, $type = 1)
    {
        switch ($type) {
            case 1:
                $user = $this->getByUserName($data['username']);
                if (empty($user)) {
                    throw new \Exception('没有该账号，请注册后登陆',ErrorCode::USER_ERROR);
                }
                if ($user->credential != md5($data['password'])) {
                    throw new \Exception('用户账号密码不匹配，请重新输入',ErrorCode::USER_PASSWORD_ERROR);
                }
                break;
            case 2:
                break;
            default :
                throw new \Exception('请正常登录', ErrorCode::SYSTEM_ERROR);
                break;
        }
        Auth::login($user);
        $returnArr['user']['nickname'] = $user->userInfo->nickname;
        $returnArr['user']['head_pic'] = $user->userInfo->head_pic;
        $returnArr['url'] = '/index';

        // todo 用户访问统计

        //end 用户访问统计
        return $returnArr;
    }

    /**
     * 后台登录
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function backendLogin($data)
    {
        $user = $this->getByUserName($data['username']);
        if (empty($user)) {
            throw new \Exception('没有该账号，请注册后登陆',ErrorCode::USER_ERROR);
        }
        if ($user->credential != md5($data['password'])) {
            throw new \Exception('用户账号密码不匹配，请重新输入',ErrorCode::USER_PASSWORD_ERROR);
        }
        $admin = $user->admin()->first();
        if (empty($admin)) {
            throw new \Exception('该账号不是管理员，请联系超级管理员',ErrorCode::ADMIN_ERROR);
        }
        Auth::guard('admin')->login($admin);

        $returnArr['admin_user'] = [
            'nickname' => $user->userInfo->nickname,
            'head_pic' => $user->userInfo->head_pic,
            'identity' => $admin->identity,
        ];
        return $returnArr;
    }
}