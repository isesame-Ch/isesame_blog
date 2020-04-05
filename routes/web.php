<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','App\UserController@store');

### END ###

Route::group(['namespace' => 'App'], function () {
    // 前端--用户注册页
    Route::get('/registered','UserController@registeredStore');
    // 前端--用户注册
    Route::post('/registered',['uses'=>'UserController@create']);

    // 前端--用户登陆页
    Route::get('/login','UserController@store');
    // 前端--用户登陆
    Route::post('/login',['uses'=>'UserController@login']);
    // 前端--用户登出
    Route::post('/logout',['uses' => 'UserController@logout']);

    // 前端--用户个人中心
    Route::get('/personal/center', 'UserController@personalCenterView');
    // 前端--用户上传图片
    Route::post('/user/upload_pic','UserController@uploadPic');
    // 前端--用户信息更新
    Route::post('/user/edit','UserController@editUserInfo');

    // 前端--首页列表页
    Route::get('/index','ArticleController@index');
    // 前端--文章--列表
    Route::get('/article/getlist', 'ArticleController@getList');
    // 前端--文章--推荐列表
    Route::get('/article/support/list', 'ArticleController@getSupportList');
    // 前端--文章页
    Route::get('/article/article_id/{id}', 'ArticleController@store');
    // 前端--文章--详情
    Route::get('/article/detail', 'ArticleController@detail');

    // 前端--关于页
    Route::get('/about',function (){return view('APP.about');});
    // 前端--个人CV页
    Route::get('/curriculum_vitae',function (){return view('APP.myCV');});
    // 前端--小游戏
    Route::get('/game',function (){return view('APP.game');});


    ### 第三方登录 begin ###
    Route::get('/oauth/qq/index','OauthController@actionIndex');

    Route::get('/oauth/qq/callback','OauthController@QQCallback');
});



############    后台管理路由    #############
// 后端--用户登陆
Route::get('/backend/login',function (){return view('Backend.login');});
// 后端--用户登陆
Route::post('/backend/login',['uses'=>'Backend\AdminController@login']);

Route::group(['namespace'=>'Backend', 'prefix'=>'backend', 'middleware' => ['admin.auth']],function () use ($router)
{
    // 后端--后台首页
    Route::get('/index','AdminController@index');
    // 后端--登出
    Route::post('/logout',['uses' => 'AdminController@logout']);

    // 后端--用户--列表页
    Route::get('/user/show', 'UserController@show');
    // 后端--用户--列表
    Route::get('/user/list', 'UserController@getList');
    // 后端--用户--编辑
    Route::post('/user/edit', 'UserController@edit');
    // 后端--用户--删除
    Route::post('/user/delete','UserController@deleted');
    // 后端--用户--注册
    Route::post('/user/add', 'UserController@create');
    // 后端--用户--上传图片
    Route::post('/user/upload_pic','UserController@uploadPic');

    #########
    # TODO BEGIN
    #########
    // 后端--权限--列表页
    Route::get('/admin/list',function (){return view('Backend.adminList');});
    // 后端--权限--列表
    Route::get('/admin/getlist',['uses'=>'AdminController@getList']);
    // 后端--权限--添加管理员
    Route::post('/admin/add',['uses'=>'AdminController@add']);
    // 后端--权限--编辑
    Route::post('/admin/edit', ['uses' => 'AdminController@edit']);
    // 后端--权限--删除
    Route::post('/admin/delete', ['uses' => 'AdminController@delete']);
    #########
    # TODO END
    #########

    // 后端--文章--发布页
    Route::get('/article/show','ArticleController@show');
    // 后端--文章--发布
    Route::post('/article/release', 'ArticleController@release');
    // 后端--文章--上传首页图片
    Route::post('/article/upload_pic','ArticleController@uploadPic');

    // 后端--文章--列表页
    Route::get('/article/list/show', 'ArticleController@listShow');
    // 后端--文章--列表
    Route::get('/article/getlist', ['uses' => 'ArticleController@getList']);
    // 后端--文章--删除
    Route::post('/article/delete', ['uses' => 'ArticleController@delete']);
    // 后端--文章--彻底删除
    Route::post('/article/remove', ['uses' => 'ArticleController@remove']);
    // 后端--文章--编辑
    Route::post('/article/edit', ['uses' => 'ArticleController@edit']);


    // 后端--文章--编辑页
    Route::get('/article/edit/{id}', 'ArticleController@editShow');
    // 后端--文章--详情
    Route::get('/article/detail', 'ArticleController@detail');
    // 后端--文章--分类管理列表页
    Route::get('/article/category/show','ArticleController@categoryShow');
    // 后端--文章--获取所有分类列表
    Route::get('/article/category/all', 'ArticleController@getCategoryList');
    // 后端--文章分类--列表
    Route::get('/article/category/list', 'ArticleController@getCategoryList');
    // 后端--文章分类--添加
    Route::post('/article/category/add', 'ArticleController@addCategory');
    // 后端--文章分类--编辑
    Route::post('/article/category/edit', 'ArticleController@editCategory');

});

Route::post('/editormd/image/upload', 'Backend\ArticleController@editormdUpload');