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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'App'], function () {
    // 前端--用户注册页
    Route::get('/registered','UserController@registeredStore');
    // 前端--用户注册
    Route::post('/registered',['uses'=>'UserController@create']);

    // 前端--用户登陆页
    Route::get('/login','UserController@store');
    // 前端--用户登陆
    Route::post('/login',['uses'=>'UserController@login']);
    // 后端--用户登出
    Route::post('/logout',['uses' => 'UserController@logout']);

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

    // 前端--小游戏
    Route::get('/game',function (){return view('APP.game');});
});



############    后台管理路由    #############
// 后端--用户登陆
Route::get('/backend/login',function (){return view('Backend.login');});
// 后端--用户登陆
Route::post('/backend/login',['uses'=>'Backend\AdminController@login']);

Route::group(['namespace'=>'Backend', 'prefix'=>'backend'],function () use ($router)
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
    Route::get('/article/release',function (){return view('Backend.releaseArticle');});
    // 后端--文章--列表页
    Route::get('/article/list',function (){return view('Backend.articleList');});
    // 后端--文章--编辑页
    Route::get('/article/edit/{id}',function ($id){return view('Backend.updateArticle',['id' => $id]);});
    // 后端--文章--分类管理页
    Route::get('/article/category',function (){return view('Backend.articleCategoryList');});

    // 后端--文章--获取分类列表
    Route::get('/article/categorylist', ['uses' => 'ArticleController@categoryList']);
    // 后端--文章--发布
    Route::post('/article/release', ['uses' => 'ArticleController@release']);
    // 后端--文章--上传图片
    Route::post('/article/upload_pic',['uses'=>'ArticleController@uploadPic']);
    // 后端--文章--列表
    Route::get('/article/getlist', ['uses' => 'ArticleController@getList']);
    // 后端--文章--编辑
    Route::post('/article/edit', ['uses' => 'ArticleController@edit']);
    // 后端--文章--删除
    Route::post('/article/delete', ['uses' => 'ArticleController@delete']);
    // 后端--文章--彻底删除
    Route::post('/article/remove', ['uses' => 'ArticleController@remove']);
    // 后端--文章--详情
    Route::get('/article/detail', ['uses' => 'ArticleController@detail']);
    // 后端--文章分类--列表
    Route::get('/article/category/list', ['uses' => 'ArticleCategoryController@getList']);
    // 后端--文章分类--编辑
    Route::post('/article/category/edit', ['uses' => 'ArticleCategoryController@edit']);
    // 后端--文章分类--删除
    Route::post('/article/category/delete', ['uses' => 'ArticleCategoryController@delete']);
    // 后端--文章分类--添加
    Route::post('/article/category/add', ['uses' => 'ArticleCategoryController@add']);

});