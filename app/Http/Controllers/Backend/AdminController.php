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
                $request->input('page_size',10),
                ['admin.*','user_auth.identifier']
            )
        );

        foreach ($adminList['data'] as &$item) {
            $item['created_at'] = date('Y-m-d H:i:s', $item['created_at']);
            $item['updated_at'] = date('Y-m-d H:i:s', $item['updated_at']);

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

    public function edit(Request $request)
    {
        $rules = [
            'admin_id' => 'required|integer',
            'identity' => 'required|in:1,2'
        ];

        if (Auth::guard('admin')->user()->identity != 2) {
            throw new \Exception('非超管不能操作', ErrorCode::ADMIN_ERROR);
        }
        $data = $this->filterParams($request, $rules);
        $admin = AdminModel::query()->find(Arr::pull($data, 'admin_id'));
        if (!$admin) {
            throw new \Exception('没有该管理员', ErrorCode::ADMIN_ERROR);
        }
        $result = $admin->update($data);

        $this->setKeyContent($result);
        return $this->responseArray();
    }

    public function delete(Request $request)
    {
        $rules = [
            'admin_id' => 'required|integer',
        ];

        if (Auth::guard('admin')->user()->identity != 2) {
            throw new \Exception('非超管不能操作', ErrorCode::ADMIN_ERROR);
        }
        $data = $this->filterParams($request, $rules);
        $admin = AdminModel::query()->find(Arr::pull($data, 'admin_id'));
        if (!$admin) {
            throw new \Exception('没有该管理员', ErrorCode::ADMIN_ERROR);
        }
        $result = $admin->delete();

        $this->setKeyContent($result);
        return $this->responseArray();
    }

    public function add(Request $request)
    {
        $rules = [
            'identifier' => 'required|string',
            'identity' => 'required|in:1,2'
        ];

        if (Auth::guard('admin')->user()->identity != 2) {
            throw new \Exception('非超管不能操作', ErrorCode::ADMIN_ERROR);
        }
        $data = $this->filterParams($request, $rules);
        $user = $this->userService->getByUserName($data['identifier'], 1);
        if (!$user) {
            throw new \Exception('没有该自建账号', ErrorCode::USER_ERROR_EXISTS);
        }

        $admin = AdminModel::query()->where(['user_id' => $user->user_id])->first();
        if ($admin) {
            throw new \Exception('该管理员已存在', ErrorCode::ADMIN_ERROR);
        }
        $admin = new AdminModel();
        $admin->user_id = $user->user_id;
        $admin->identity = $data['identity'];
        $admin->created_at = time();
        $result = $admin->save();

        $this->setKeyContent($result);
        return $this->responseArray();
    }
}
