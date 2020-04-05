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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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
        $userAuthArr = ['identity_type', 'identifier', 'credential'];
        $userArr = ['nickname', 'email', 'head_pic', 'mobile'];

        foreach ($data as $key => $value) {
            if (in_array($key,$userAuthArr)) {
                $userAuth[$key] = $value;
            }
            if (in_array($key,$userArr)) {
                $user[$key] = $value;
            }
        }
        $createTime = time();

        DB::beginTransaction();
        $userModel = new UserModel();
        $userModel->nickname = $user['nickname'];
        $userModel->email = $user['email'];
        $userModel->created_at = $createTime;
        $userResult = $userModel->save();

        if ($userResult) {
            $userAuthModel = new UserAuthModel();
            $userAuthModel->identity_type = $userAuth['identity_type'];
            $userAuthModel->identifier = $userAuth['identifier'];
            $userAuthModel->credential = $userAuth['credential'];
            $userAuthModel->created_at = $userAuth['created_at'];
            $userAuthModel->user_id = $userModel->id;
            $userAuthResult = $userAuthModel->save();
        }
        if ($userResult && $userAuthResult) {
            DB::commit();
        } else {
            DB::rollback();
        }

        return $userModel->id;
    }

    /**
     * 用户登录
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function login($data)
    {
        $user = $this->getByUserName($data['username']);
        if (empty($user)) {
            throw new \Exception('没有该账号，请注册后登陆',ErrorCode::USER_ERROR);
        }
        if ($user->credential != md5($data['password'])) {
            throw new \Exception('用户账号密码不匹配，请重新输入',ErrorCode::USER_PASSWORD_ERROR);
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
     * 后台管理员登录
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