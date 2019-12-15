<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ErrorCode;
use App\Http\Services\AdminService;
use App\Http\Services\UserService;
use App\Models\UserModel;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/backend/login';

    protected $userService;
    protected $adminService;

    /**
     * AdminController constructor.
     * @param UserService $userService
     * @param AdminService $adminService
     */
    public function __construct(UserService $userService, AdminService $adminService)
    {
        $this->middleware('admin.auth',[
            'except' => ['logout','login']
        ]);

        $this->userService = $userService;
        $this->adminService = $adminService;
    }

    /**
     * @param Request $request
     * @return AdminController
     * @throws \Illuminate\Validation\ValidationException|\Exception
     */
    public function login(Request $request)
    {
        $rules = [
            'username' => 'bail||required||max:20|min:6',
            'password' => 'bail||required||max:50|min:6',
        ];
        $data = $this->filterParams($request,$rules);

        $user = $this->userService->getByUserName($data['username']);
        if (empty($user)) {
            throw new \Exception('没有该账号，请注册后登陆',ErrorCode::USER_ERROR);
        }
        if ($user->password != $data['password']) {
            throw new \Exception('用户账号密码不匹配，请重新输入',ErrorCode::USER_PASSWORD_ERROR);
        }
        $isAdmin = $this->obj2Array($user->admin()->first());
        if (count($isAdmin) == 0) {
            throw new \Exception('该账号不是管理员，请联系超级管理员',ErrorCode::ADMIN_ERROR);
        }
        Auth::guard('admin')->login($user);

        $returnArr['admin_user'] = [
            'nickname' => $user->nickname,
            'head_pic' => $user->head_pic,
            'identity' => $isAdmin['identity'],
        ];
        $this->setKeyContent($returnArr);
        return $this->responseArray();
    }

    /**
     * 登出
     * @return AdminController
     */
    public function logout()
    {
        Auth::logout();
        $this->setKeyContent();
        return $this->responseArray();
    }

    /**
     * 后台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('Backend.index');
    }
}
