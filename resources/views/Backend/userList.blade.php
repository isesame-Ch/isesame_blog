
@extends('layouts.backend')
@section('main_content')
    <!--main content start-->
    <section class="main-content-wrapper">
        <section id="main-content">
            <div class="row">
                <div class="col-md-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li>
                            <a href="/backend/index">首页</a>
                        </li>
                        <li>用户管理</li>
                        <li class="active">用户列表</li>
                    </ul>
                    <!--breadcrumbs end -->
                    <h1 class="h1">用户管理</h1>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="alert alert-danger alert-dismissable hidden" id="search_alert">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <span></span>
                            </div>
                            <form class="form-inline col-md-8" style="height: 45px;line-height: 45px;color:#999999;" id="search_form">
                                <div class="form-group" style="margin-left:10px;">
                                    <lable for="username">账号:</lable>
                                    <input type="text" class="form-control" id="username" name="username" autocomplete="off">
                                </div>
                                <div class="form-group" style="margin-left:10px;">
                                    <lable for="nickname">昵称:</lable>
                                    <input type="text" class="form-control" id="nickname" name="nickname" autocomplete="off">
                                </div>
                                <div class="form-group" style="margin-left:10px;">
                                    <lable for="email">邮箱:</lable>
                                    <input type="email" class="form-control" id="email" name="email"autocomplete="off">
                                </div>
                                <div class="form-group" style="margin-left:10px;">
                                    <button type="button" class="btn btn-primary btn-trans form-control" id="search_btn" style="margin-top: 5px">搜索</button>
                                </div>
                                <div class="form-group" style="margin-left:10px;">
                                    <button type="button" class="btn btn-warning btn-trans form-control" id="clear_btn" style="margin-top: 5px">清空</button>
                                </div>
                            </form>
                            <!-- Button trigger modal -->
                            {{--<button class="btn btn-primary" data-toggle="modal" data-target="#formModal" style="margin-top: 5px">添加</button>--}}
                        </div>
                    </div>
                    {{--创建用户--}}
                    <!-- Form Modal -->
                    {{--<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
                        {{--<div class="modal-dialog">--}}
                            {{--<div class="modal-content">--}}
                                {{--<div class="modal-header">--}}
                                    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
                                    {{--<h4 class="modal-title" id="myModalLabel">添加用户</h4>--}}
                                {{--</div>--}}
                                {{--<div class="modal-body">--}}
                                    {{--<form class="form-horizontal" role="form" id="add_form">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="username" class="col-sm-2 control-label">账号</label>--}}
                                            {{--<div class="col-sm-10">--}}
                                                {{--<input type="text" class="form-control" name="username" id="new_username" placeholder="账号">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="password" class="col-sm-2 control-label">密码</label>--}}
                                            {{--<div class="col-sm-10">--}}
                                                {{--<input type="password" class="form-control" name="password" id="new_password" placeholder="密码">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="nickname" class="col-sm-2 control-label">昵称</label>--}}
                                            {{--<div class="col-sm-10">--}}
                                                {{--<input type="text" class="form-control" name="nickname" id="new_nickname" placeholder="昵称">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="email" class="col-sm-2 control-label">Email</label>--}}
                                            {{--<div class="col-sm-10">--}}
                                                {{--<input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="mobile" class="col-sm-2 control-label">手机</label>--}}
                                            {{--<div class="col-sm-10">--}}
                                                {{--<input type="text" class="form-control" name="mobile" id="new_mobile" placeholder="手机号">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group hidden">--}}
                                            {{--<div class="col-sm-10">--}}
                                                {{--<input type="text" class="form-control" name="head_pic" id="new_head_pic" placeholder="图片">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</form>--}}
                                    {{--<form action="#" class="form-horizontal" id="photoForm" enctype="multipart/form-data">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="upload_pic" class="col-sm-2 control-label">头像</label>--}}
                                            {{--<div class="col-sm-10">--}}
                                                {{--<input type="file" class="form-control" name="upload_pic" id="upload_pic" placeholder="图片">--}}
                                                {{--<div><img src="" alt="" id="upload_img" style="width: 150px;height: 150px;margin-top: 10px"></div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</form>--}}
                                {{--</div>--}}
                                {{--<div class="modal-footer">--}}
                                    {{--<button type="button" class="btn btn-primary" id="add_btn">添加</button>--}}
                                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <!-- End Form Modal -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="panel-title">用户列表</span>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover" id="user_list">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="display:none">id</th>
                                    <th>账号</th>
                                    <th>昵称</th>
                                    <th>邮箱</th>
                                    <th>账号类型</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--<tr>--}}
                                {{--<td class="num">1</td>--}}
                                {{--<td class="user_id" style="display:none">123</td>--}}
                                {{--<td class="username">Mark</td>--}}
                                {{--<td class="nickname">Otto</td>--}}
                                {{--<td class="email">798345369@qq.com</td>--}}
                                {{--<td class="created_at">2018/7/28 21:07:43</td>--}}
                                {{--<td>--}}
                                {{--<button class="btn btn-primary btn-sm edit_btn" data-toggle="modal" data-target="#updateModal">编辑</button>--}}
                                {{--<button class="btn btn-danger btn-sm delete_btn">删除</button>--}}
                                {{--</td>--}}
                                {{--</tr>--}}
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- update Modal -->
                    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">编辑用户</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" role="form" id="edit_form">
                                        <div class="form-group">
                                            <label for="user_id" class="col-sm-2 control-label">ID</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="user_id" id="edit_id" placeholder="ID" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="username" class="col-sm-2 control-label">账号</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="username" id="edit_username" placeholder="账号" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nickname" class="col-sm-2 control-label">昵称</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nickname" id="edit_nickname" placeholder="昵称">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email" id="edit_email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="mobile" class="col-sm-2 control-label">手机</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="mobile" id="edit_mobile" placeholder="手机号">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="update_btn">保存</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End update Modal -->
                </div>
            </div>
        </section>
    </section>
    <!--main content end-->
@stop

<!--Load these page level functions-->
@section('js')
    <!--Load transform timestamp-->
    <script src="/js/timestamp-transform.js"></script>
    <!--END transform timestamp-->
    <script>
        $(function () {
            var page = 1;
            var page_size = 10;

            //获取列表
            function getList(page=1,page_size=10){
                $data = $("#search_form").serialize();
                $_page = page;
                $_page_size = page_size;
                $data = $data+"&page="+$_page+"&page_size="+$_page_size;
                $.ajax({
                    type:"GET",
                    url:"/backend/user/list",
                    data:$data,
                    dataType:"json",
                    success:function (data) {
                        if (data.code == 0) {
                            //清空表格和分页
                            $("#user_list tbody").html('');
                            $("#user_list ul").remove();
                            //显示分页栏
                            $("#user_list").append(
                                "<ul class=\"pagination \">\n" +
                                "<li><a href=\"javascript:void(0)\" class='pagination_a'>&laquo;</a></li>\n" +
                                "</ul>"
                            );
                            for ($i=1;$i<=data.content.total_page;$i++){
                                $("#user_list ul").append(
                                    "<li><a href=\"javascript:void(0)\" class='pagination_a'>"+$i+"</a></li>\n"
                                );
                            }
                            $("#user_list ul").append(
                                "<li><a href=\"javascript:void(0)\" class='pagination_a'>&raquo;</a></li>"
                            );
                            $lis = $("#user_list ul li");
                            $lis[data.content.current_page].className = 'active';

                            //加载表格
                            $list = data.content.list;
                            $i=1;
                            $list.forEach(function ($item) {
                                $("#user_list tbody").append(
                                    "<tr>" +
                                    "<td class=\"num\">"+$i+"</td>" +
                                    "<td class=\"user_id\" style=\"display:none\">"+$item.id+"</td>" +
                                    "<td class=\"username\">"+$item.username+"</td>" +
                                    "<td class=\"nickname\">"+$item.nickname+"</td>" +
                                    "<td class=\"email\">"+$item.email+"</td>" +
                                    "<td class=\"mobile\">"+$item.mobile+"</td>" +
                                    "<td class=\"identity_type\">"+$item.identity_type+"</td>" +
                                    "<td class=\"created_at\">"+$item.created_at+"</td>" +
                                    "<td>" +
                                    "<button class=\"btn btn-primary btn-sm edit_btn\" data-toggle=\"modal\" data-target=\"#updateModal\" style=\"margin-left: 5px\">编辑</button>" +
                                    "<button class=\"btn btn-danger btn-sm delete_btn\" style=\"margin-left: 5px\">删除</button>" +
                                    "</td>" +
                                    "</tr>"
                                );
                                $i++;
                            })
                        } else {
                            $("#search_alert").removeClass("hidden");
                            $("#search_alert span").html("<strong>出错喽~！</strong>");
                            $("#search_alert span").append("<strong>"+data.message+"</strong>");
                        }
                    },
                    error: function (e) {
                        $("#search_alert").removeClass("hidden");
                        $("#search_alert span").html("<strong>出错喽~！</strong>");
                        if (e.responseJSON.message) {
                            $("#search_alert span").append("<strong>"+e.responseJSON.message+"</strong>");
                        }
                        if (e.responseJSON.errors) {
                            for($item in e.responseJSON.errors) {
                                $("#search_alert span").html($item+"格式不符合要求");
                            }
                        }
                    }
                });
            }

            //加载获取列表
            getList(page,page_size);
            //搜索
            $("#search_btn").on("click",function () {
                getList(page,page_size);
            });
            //清空搜索
            $("#clear_btn").on("click",function () {
                window.location = "";
            });
            //分页请求
            $("#user_list").on('click','.pagination_a',function(){
                var _this = $(this);
                var _page = _this[0].innerText;
                if (_page === '«') {
                    _page = 1;
                }else if (_page === '»') {
                    //最后一页
                    _page = _this.parent().parent().children('li').length-2;
                }
                getList(_page,page_size);
            });

            //提交编辑
            $("#user_list").on("click",'.edit_btn',function () {
                var td = $(this).parent().parent().children('td');
                var id = td[1].innerText;
                var username = td[2].innerText;
                var nickname = td[3].innerText;
                var email = td[4].innerText;
                var mobile = td[5].innerText;
                $("#edit_id").val(id);
                $("#edit_username").val(username);
                $("#edit_nickname").val(nickname);
                $("#edit_email").val(email);
                $("#edit_mobile").val(mobile);
            });

            $("#update_btn").on("click",function () {
                var data = $("#edit_form").serialize();
                data = data;
                $.ajax({
                    url:'/backend/user/edit',
                    type:'post',
                    data:data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:"json",
                    success:function (data) {
                        if (data.code == 0) {
                            alert('编辑成功');
                            window.location.reload();
                        } else {
                            alert('编辑失败:'+data.message);
                            window.location.reload();
                        }
                    },
                    error:function (e) {
                        alert('编辑失败:'+e.responseJSON.message);
                        window.location.reload();
                    }

                })
            });

            //删除用户
            $("#user_list").on("click",'.delete_btn',function () {
                var td = $(this).parent().parent().children('td');
                var id = td[1].innerText;
                $.ajax({
                    url:'/backend/user/delete',
                    type:'post',
                    data:{'user_id':id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:"json",
                    success:function (data) {
                        if (data.code == 0) {
                            alert('删除成功');
                            window.location.reload();
                        } else {
                            alert('删除失败');
                            window.location.reload();
                        }
                    },
                    error:function (e) {
                        console.log(e);
                        alert('删除失败');
                        // window.location.reload();
                    }

                })
            });

            //上传图片
            $("#upload_pic").on("change",function () {
                var upload_pic = new FormData($("#photoForm")[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    type: 'POST',
                    url:'/backend/user/upload_pic',
                    data: new FormData($("#photoForm")[0]),
                    processData:false,
                    contentType: false,
                    cache: false,
                    success:function (data) {
                        if (data.code == 0) {
                            $("#new_head_pic").val(data.content);
                            $("#upload_img").attr('src','/uploads'+data.content);
                        } else {
                            alert('图片上传失败');
                        }
                    },
                    error:function (e) {
                        console.log(e);
                        alert('图片上传失败');
                    }
                });
            });

            //添加用户
            // $("#add_btn").on("click",function () {
            //     var data = $("#add_form").serialize();
            //
            //     $.ajax({
            //         url:'/backend/user/add',
            //         type:'post',
            //         data:data,
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         dataType:"json",
            //         success:function (data) {
            //             if (data.code == 0) {
            //                 alert('添加成功');
            //                 console.log(data);
            //                 window.location.reload();
            //             } else {
            //                 alert(data.message);
            //             }
            //         },
            //         error:function (e) {
            //             console.log(e);
            //             alert('添加失败:'+e.responseJSON.message);
            //         }
            //
            //     })
            // });
        })

    </script>
@stop

