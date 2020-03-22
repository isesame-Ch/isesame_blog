<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ErrorCode;
use App\Http\Services\AdminService;
use App\Http\Services\UserService;
use App\Models\AdminModel;
use App\Models\UserModel;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
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
//        $this->middleware('admin.auth',[
//            'except' => ['logout','login']
//        ]);

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
            'username' => 'bail|required|max:20|min:6',
            'password' => 'bail|required|max:50|min:6',
        ];
        $data = $this->filterParams($request,$rules);

        $returnArr = $this->userService->backendLogin($data);
        $this->setKeyContent($returnArr);
        return $this->responseArray();
    }

    /**
     * 登出
     * @return AdminController
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
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

    public function getList(Request $request)
    {
        $rules = [
            'username' => 'string|nullable',
            'mobile' => 'string|nullable',
        ];
        $data = $this->filterParams($request,$rules);

        $where = [];
        if (Arr::has($data, 'username')) {
            $where[] = ['user_auth.identifier', 'like', '%'.$data['username'].'%'];
        }
        $adminList = $this->obj2Array(
            AdminModel::getList(
                $where,
                $request->input('page_size',10)
            )
        );

        foreach ($adminList['data'] as &$item) {
            $item['created_at'] = date('Y-m-d H:i:s', $item['created_at']);
            $item['updated_at'] = date('Y-m-d H:i:s', $item['updated_at']);

            $item['username'] = $item['identifier'];
            unset($item['credential']);
            $item['nickname'] = $item['user_info']['nickname'];
            $item['email'] = $item['user_info']['email'];
            unset($item['user_info']);

            switch ($item['identity']) {
                case 1:
                    $item['identity'] = '管理员';
                    break;
                case 2:
                    $item['identity'] = '超级管理员';
                    break;
                default :
                    $item['identity'] = '未知';
                    break;
            }
        }
        $this->setKeyContent($this->listData($adminList));
        return $this->responseArray();
    }
}
