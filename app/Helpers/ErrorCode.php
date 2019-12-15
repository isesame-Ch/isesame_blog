<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/6 0006
 * Time: 上午 9:44
 */

namespace App\Helpers;

class ErrorCode
{

    /*
    |10502
    |--------------------------------------------------------------------------|
    | 1                       | 05              | 02                           |
    |--------------------------------------------------------------------------|
    | 业务级错误[2为系统级错误]  | 服务模块代码     | 具体错误代码                   |
    |--------------------------------------------------------------------------|
    */

    const SUCCESS = 0; // 请求成功

    // 业务级错误
    const SYSTEM_ERROR              = 10000;    // 系统错误

    const USER_ERROR_EXISTS         = 10001;    // 用户名或昵称已存在
    const USER_EMAIL_BINDED         = 10002;    // 邮箱已绑定
    const USER_ERROR                = 10003;    // 用户不存在
    const USER_PASSWORD_ERROR       = 10004;    // 用户密码错误
    const USER_HAS_NOT_LOGIN        = 10005;    // 用户未登录

    const ADMIN_ERROR               = 10010;    // 该用户不是管理员
    const FILE_EXTENSION_ERROR      = 10020;    // 文件格式错误


    // 系统级错误
    const DB_ERROR                  = 20000;    // 数据库错误
    const DB_ERROR_INSERT           = 20001;    // 数据库写入错误

}
