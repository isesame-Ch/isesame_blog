<?php

namespace App\Http\Controllers\Backend;

use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class UserController extends Controller
{
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
            $where[] = ['username', 'like', '%'.$data['username'].'%'];
        }
        if (Arr::has($data, 'nickname')) {
            $where[] = ['nickname', 'like', '%'.$data['nickname'].'%'];
        }
        if (Arr::has($data, 'email')) {
            $where[] = ['email', 'like', '%'.$data['email'].'%'];
        }
        $users = $this->obj2Array(
            UserModel::getList(
                [],
                $request->input('page_size',10)
            )
        );

        foreach ($users['data'] as &$item) {
            $item['created_at'] = date('Y-m-d H:i:s', $item['created_at']);
            $item['updated_at'] = date('Y-m-d H:i:s', $item['updated_at']);
        }

        $this->setKeyContent($users);
        return $this->responseArray();
    }
}
