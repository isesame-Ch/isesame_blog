<?php

namespace App\Http\Controllers\App;

use App\Helpers\ErrorCode;
use App\Http\Services\UserService;
use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('user.auth', [
            'only' => ['logOut']
        ]);
    }

    public function store()
    {
        return view('APP.login');
    }

    public function registeredStore()
    {
        return view('APP.registered');
    }

    /**
     * 注册用户
     * @param Request $request
     * @return UserController
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $rules =  [
            'username' => 'bail||required||max:20|min:6',
            'password' => 'bail||required||max:20|min:6',
            'nickname' => 'bail|required|max:10',
            'email' => 'bail|required|email',
            'head_pic' => 'nullable'
        ];
        $data = $this->filterParams($request, $rules);

        if (UserModel::isUserNameExists($data['username'], $data['nickname'])) {
            throw new \Exception('该用户名或昵称已存在', ErrorCode::USER_ERROR_EXISTS);
        };
        if (UserModel::isEmailBinded($data['email'])) {
            throw new \Exception('该邮箱已绑定', ErrorCode::USER_EMAIL_BINDED);
        };
        $user = new UserModel();
        $user->username = $data['username'];
        $user->password = md5($data['password']);
        $user->nickname = $data['nickname'];
        $user->email = $data['email'];
        $user->created_at = time();
        $result = $user->save();
        $this->setKeyContent(['url'=>'/login']);
        return $this->responseArray();
    }

    /**
     * 登录
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $rules = [
            'username' => 'bail||required||max:20|min:6',
            'password' => 'bail||required||max:50|min:6',
        ];
        $data = $this->filterParams($request, $rules);

        $user = $this->userService->getByUserName($data['username']);
        if (!$user || empty($user)) {
            throw new \Exception('没有该账号，请注册后登陆',ErrorCode::USER_ERROR);
        }
        if ($user->password != $data['password']) {
            throw new \Exception('用户账号密码不匹配，请重新输入',ErrorCode::USER_PASSWORD_ERROR);
        }
        Auth::login($user);
        $returnArr['user']['nickname'] = $user->nickname;
        $returnArr['user']['head_pic'] = $user->head_pic;
        $returnArr['url'] = '/index';

        // todo 用户访问统计

        //end 用户访问统计
        $this->setKeyContent($returnArr);
        return $this->responseArray();
    }

    /**
     * 登出
     * @param Request $request
     * @return UserController
     */
    public function logOut(Request $request)
    {
        Auth::logout();
        $return = ['url'=>'/login'];
        $this->setKeyContent($return);
        return $this->responseArray();
    }
}
