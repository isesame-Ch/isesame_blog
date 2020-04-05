<?php

namespace App\Http\Controllers\App;

use App\Exceptions\DataBaseException;
use App\Helpers\ErrorCode;
use App\Http\Services\UserService;
use App\Models\UserAuthModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('user.auth', [
            'only' => ['logOut', 'personalCenterView']
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
     * @throws DataBaseException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $rules =  [
            'username' => 'bail|required|max:20|min:6',
            'password' => 'bail|required|max:20|min:6',
            'nickname' => 'bail|required|max:10',
            'email' => 'bail|required|email',
            'mobile' => 'bail|required',
            'head_pic' => 'nullable'
        ];
        $data = $this->filterParams($request, $rules);

        if (UserAuthModel::isUserNameExists($data['username'], 1)) {
            throw new \Exception('该用户名或昵称已存在', ErrorCode::USER_ERROR_EXISTS);
        };
        if (UserModel::isNickNameExists($data['nickname'])) {
            throw new \Exception('该用户名或昵称已存在', ErrorCode::USER_ERROR_EXISTS);
        };
        if (UserModel::isEmailBinded($data['email'])) {
            throw new \Exception('该邮箱已绑定', ErrorCode::USER_EMAIL_BINDED);
        };

        DB::beginTransaction();
        try {
            $user = new UserModel();
            $user->nickname = $data['nickname'];
            $user->email = $data['email'];
            $user->mobile = $data['mobile'];
            $user->created_at = time();
            $userResult = $user->save();

            $userAuth = new UserAuthModel();
            $userAuth->user_id = $user->id;
            $userAuth->identity_type = 1;
            $userAuth->identifier = $data['username'];
            $userAuth->credential = md5($data['password']);
            $userAuth->created_at = time();
            $userAuthResult = $userAuth->save();
        } catch (\Exception $e) {
            DB::rollback();
            switch ($e->getCode()) {
                case 'HY000':
                    throw new DataBaseException($e->getMessage());
                    break;
                default :
                    throw new \Exception($e->getMessage(), $e->getCode());
            }
        }
        if ($userResult && $userAuthResult) {
            DB::commit();
        } else {
            DB::rollback();
        }

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
            'username' => 'bail|required|max:20|min:6',
            'password' => 'bail|required|max:50|min:6',
        ];
        $data = $this->filterParams($request, $rules);

        $returnArr = $this->userService->login($data, 1);

        $userCookie = [
            'nickname' => $returnArr['user']['nickname'],
            'head_pic' => $returnArr['user']['head_pic']
        ];
        return redirect('/index');
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

    /**
     * 个人中心页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function personalCenterView(Request $request)
    {
        return view('APP.personalCenter');
    }

    /**
     * 上传头像
     * @param Request $request
     * @return bool|string
     * @throws \Exception
     */
    public function uploadPic(Request $request)
    {
        $rules = [
            'upload_pic' => 'required'
        ];
        $this->validate($request, $rules);
        $file = $request->file('upload_pic');
        $extension = $file->getClientOriginalExtension();

        if (!in_array($extension,['jpg','png','gif','jpeg'])) {
            throw new \Exception('只能上传以jpg,png,gif,jpeg作后缀的图片哦~',ErrorCode::FILE_EXTENSION_ERROR);
        }
        $currentDate = Date('Ym',time());
        $file_path = '/uploads/user_head/'.$currentDate;
        $filename = md5('upload'.rand(1000,9999).microtime()). '.' .$extension;
        $file->move(public_path($file_path),$filename);

        $this->setKeyContent('/user_head/'.$currentDate.'/'.$filename);
        return $this->responseArray();
    }

    /**
     * 更新用户信息
     * @param Request $request
     * @return UserController
     * @throws \Illuminate\Validation\ValidationException
     */
    public function editUserInfo(Request $request)
    {
        $rules =  [
            'nickname' => 'bail|required|max:50',
            'email' => 'bail|required|email',
            'mobile' => 'bail|required|integer',
            'head_pic' => 'required|string'
        ];
        if (!Auth::check()) {
            throw new \Exception('请先登录', ErrorCode::SYSTEM_ERROR);
        }
        $data = $this->filterParams($request, $rules);
        $data['user_id'] = Auth::user()->user_id;
        $user = UserModel::query()->find($data['user_id']);
        if (!$user) {
            throw new \Exception('该用户名不存在', ErrorCode::USER_ERROR_EXISTS);
        }
        if ($data['nickname'] != $user->nickname && UserModel::isNickNameExists($data['nickname'])) {
            throw new \Exception('该昵称已存在', ErrorCode::USER_ERROR_EXISTS);
        };
        if ($data['email'] != $user->email && UserModel::isEmailBinded($data['email'])) {
            throw new \Exception('该邮箱已绑定', ErrorCode::USER_EMAIL_BINDED);
        };
        if ($data['mobile'] != $user->mobile && UserModel::isMobileBinded($data['mobile'])) {
            throw new \Exception('该邮箱已绑定', ErrorCode::USER_EMAIL_BINDED);
        };

        $user->nickname = $data['nickname'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        $user->head_pic = $data['head_pic'];
        $user->updated_at = time();
        $userResult = $user->save();
        return $this->setKeyContent($userResult)->responseArray();
    }
}
