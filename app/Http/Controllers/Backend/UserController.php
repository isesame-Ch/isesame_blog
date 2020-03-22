<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ErrorCode;
use App\Http\Services\UserService;
use App\Models\UserAuthModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 用户列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('Backend.userList');
    }

    /**
     * 获取用户列表
     */
    public function getList(Request $request)
    {
        $rules = [
            'username' => 'string|max:20|nullable',
            'nickname' => 'string|nullable',
            'email' => 'email|nullable',
        ];
        $data = $this->filterParams($request, $rules);
        $where = [];
        if (Arr::has($data, 'username')) {
            $where[] = ['identifier', 'like', '%'.$data['username'].'%'];
        }
        if (Arr::has($data, 'nickname')) {
            $where[] = ['nickname', 'like', '%'.$data['nickname'].'%'];
        }
        if (Arr::has($data, 'email')) {
            $where[] = ['email', 'like', '%'.$data['email'].'%'];
        }
        $users = $this->obj2Array(
            UserModel::getList(
                $where,
                $request->input('page_size',10)
            )
        );

        foreach ($users['data'] as &$item) {
            $item['created_at'] = date('Y-m-d H:i:s', $item['created_at']);
            $item['updated_at'] = date('Y-m-d H:i:s', $item['updated_at']);
            $item['username'] = $item['user_auth'][0]['identifier'];
            switch ($item['user_auth'][0]['identity_type']) {
                case 1:
                    $item['identity_type'] = '自建账户';
                    break;
                case 2:
                    $item['identity_type'] = 'QQ登录';
                    break;
                default :
                    $item['identity_type'] = '还未设置';
                    break;
            }
        }

        $this->setKeyContent($this->listData($users));
        return $this->responseArray();
    }

    /**
     * 添加用户
     * @param Request $request
     * @return UserController
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $rules =  [
            'username' => 'bail||required||max:20|min:6',
            'password' => 'bail||required||max:20|min:6',
            'nickname' => 'bail|required|max:10',
            'email' => 'bail|required|email',
            'mobile' => 'bail|required',
            'head_pic' => 'nullable'
        ];
        $data = $this->filterParams($request, $rules); if (UserAuthModel::isUserNameExists($data['username'],1)) {
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
        $this->setKeyContent(true);
        return $this->responseArray();
    }

    /**
     * 编辑用户
     * @param Request $request
     * @return UserController
     * @throws \Exception
     */
    public function edit(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer',
            'username' => 'required|string',
            'nickname' => 'required|string',
            'email' => 'required|email'
        ];
        $data = $this->filterParams($request, $rules);

        $user = UserModel::find(Arr::pull($data,'user_id'));
        if (empty($user)) {
            throw new \Exception('没有该账号',ErrorCode::USER_ERROR);
        }
        $data['updated_at'] = time();
        $result = $user->update($data);

        $this->setKeyContent($result);
        return $this->responseArray();
    }

    /**
     * 删除用户
     * @param Request $request
     * @return UserController
     * @throws \Exception
     */
    public function deleted(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer',
        ];
        $data = $this->filterParams($request, $rules);

        $user = UserModel::find(Arr::pull($data,'user_id'));
        if (empty($user)) {
            throw new \Exception('没有该账号',ErrorCode::USER_ERROR);
        }
        $result = $user->delete();

        $this->setKeyContent($result);
        return $this->responseArray();
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
}
