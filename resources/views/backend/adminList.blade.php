
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
                        <li class="active">权限管理</li>
                    </ul>
                    <!--breadcrumbs end -->
                    <h1 class="h1">权限管理</h1>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="alert alert-danger alert-dismissable hidden" id="search_alert">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <span></span>
                            </div>
                            <form class="form-inline col-md-8" id="search_form" style="height: 45px;line-height: 45px;color:#999999;">
                                <div class="form-group">
                                    <lable for="username">账号:</lable>
                                    <input type="text" class="form-control" id="username" name="username" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <lable for="nickname">昵称:</lable>
                                    <input type="text" class="form-control" id="nickname" name="nickname" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <lable for="email">邮箱:</lable>
                                    <input type="email" class="form-control" id="email" name="email"autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-trans form-control" id="search_btn">搜索</button>
                                </div>
                            </form>
                            <!-- Button trigger modal -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#formModal" style="margin-top: 5px">添加</button>
                        </div>
                    </div>
                    <!-- Form Modal -->
                    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">添加管理员</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" role="form" id="add_admin_form">
                                        <div class="form-group">
                                            <label for="username" class="col-sm-2 control-label">账号</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="username" id="new_username" placeholder="账号" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="identity" class="col-sm-2 control-label">权限等级</label>
                                            <div class="col-sm-10">
                                                <select name="identity" id="new_identity"  class="form-control">
                                                    <option value="1">普通用户</option>
                                                    <option value="2">管理员</option>
                                                    <option value="3">超级管理员</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="add_admin_btn">添加</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Form Modal -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- update Modal -->
                    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">编辑管理员权限</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" role="form" id="edit_form">
                                        <div class="form-group">
                                            <label for="admin_id" class="col-sm-2 control-label">ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="admin_id" id="edit_id" placeholder="管理员ID" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="username" class="col-sm-2 control-label">账号</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="username" id="edit_username" placeholder="账号" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="identity" class="col-sm-2 control-label">权限等级</label>
                                            <div class="col-sm-10">
                                                <select name="identity" id="edit_identity"  class="form-control">
                                                    <option value="1">普通用户</option>
                                                    <option value="2">管理员</option>
                                                    <option value="3">超级管理员</option>
                                                </select>
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="panel-title">权限列表</span>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover" id="admin_list">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="display:none">id</th>
                                    <th>账号</th>
                                    <th>角色权限</th>
                                    <th>昵称</th>
                                    <th>邮箱</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--<tr>--}}
                                {{--<td>1</td>--}}
                                {{--<td>12</td>--}}
                                {{--<td>Mark</td>--}}
                                {{--<td>Otto</td>--}}
                                {{--<td>Otto</td>--}}
                                {{--<td>Otto</td>--}}
                                {{--<td>--}}
                                {{--<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal">编辑</button>--}}
                                {{--<button class="btn btn-danger btn-sm">删除</button>--}}
                                {{--</td>--}}
                                {{--</tr>--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            //获取列表
            function getList(page=1,page_size=10){
                var data = $("#search_form").serialize();
                var _page = page;
                var _page_size = page_size;
                data = data+"&page="+_page+"&page_size="+_page_size;
                $.ajax({
                    type:'get',
                    url:'/backend/admin/getlist',
                    data:data,
                    dataType:'json',
                    success:function (data) {
                        if (data.code == 0)
                        {
                            //清空表格和分页
                            $("#admin_list tbody").html('');
                            $("#admin_list ul").remove();

                            //显示分页栏
                            $("#admin_list").append(
                                "<ul class=\"pagination \">\n" +
                                "<li><a href=\"javascript:void(0)\" class='pagination_a'>&laquo;</a></li>\n" +
                                "</ul>"
                            );
                            for ($i=1;$i<=data.content.total_page;$i++){
                                $("#admin_list ul").append(
                                    "<li><a href=\"javascript:void(0)\" class='pagination_a'>"+$i+"</a></li>\n"
                                );
                            }
                            $("#admin_list ul").append(
                                "<li><a href=\"javascript:void(0)\" class='pagination_a'>&raquo;</a></li>"
                            );
                            $lis = $("#admin_list ul li");
                            $lis[data.content.current_page].className = 'active';

                            //加载表格
                            $list = data.content.list;
                            $i=1;
                            $list.forEach(function ($item) {
                                $item.created_at = $item.created_at;
                                $("#admin_list tbody").append(
                                    "<tr>" +
                                    "<td class=\"num\">"+$i+"</td>" +
                                    "<td class=\"admin_id\" style=\"display:none\">"+$item.id+"</td>" +
                                    "<td class=\"username\">"+$item.username+"</td>" +
                                    "<td class=\"username\">"+$item.identity+"</td>" +
                                    "<td class=\"nickname\">"+$item.nickname+"</td>" +
                                    "<td class=\"email\">"+$item.email+"</td>" +
                                    "<td class=\"created_time\">"+$item.created_at+"</td>" +
                                    "<td>" +
                                    "<button class=\"btn btn-primary btn-sm edit_btn\" data-toggle=\"modal\" data-target=\"#updateModal\" style=\"margin-left: 5px\">编辑</button>" +
                                    "<button class=\"btn btn-danger btn-sm delete_btn\" style=\"margin-left: 5px\">删除</button>" +
                                    "</td>" +
                                    "</tr>"
                                );
                                $i++;
                            })
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
            };


            var page = 1;
            var page_size = 10;

            //加载获取列表
            getList(page,page_size);
            //搜索
            $("#search_btn").on("click",function () {
                getList(page,page_size);
            });
            //分页请求
            $("#admin_list").on('click','.pagination_a',function(){
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
            $("#admin_list").on("click",'.edit_btn',function () {
                var td = $(this).parent().parent().children('td');
                var id = td[1].innerText;
                var username = td[2].innerText;
                var identity = td[3].innerText;
                switch (identity)
                {
                    case '普通用户':
                        $("#edit_identity").val(1);
                        break;
                    case '管理员':
                        $("#edit_identity").val(2);
                        break;
                    case '超级管理员':
                        $("#edit_identity").val(3);
                        break;
                    default:
                        $("#edit_identity").val(1);
                }
                $("#edit_id").val(id);
                $("#edit_username").val(username);
            });

            $("#update_btn").on("click",function () {
                var data = $("#edit_form").serialize();
                $.ajax({
                    url:'/backend/admin/edit',
                    type:'post',
                    data:data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:"json",
                    success:function (data) {
                        if (data.code == 0)
                        {
                            alert('编辑成功');
                            window.location.reload();
                        }
                    },
                    error:function (e) {
                        alert('编辑失败');
                        // window.location.reload();
                    }

                })
            });

            //删除用户
            $("#admin_list").on("click",'.delete_btn',function () {
                var td = $(this).parent().parent().children('td');
                var id = td[1].innerText;
                $.ajax({
                    url:'/backend/admin/delete',
                    type:'post',
                    data:{'admin_id':id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:"json",
                    success:function (data) {
                        if (data.code == 0)
                        {
                            alert('删除成功');
                            window.location.reload();
                        }
                    },
                    error:function (e) {
                        console.log(e);
                        alert('删除失败');
                        window.location.reload();
                    }

                })
            });

            //添加管理员
            $("#add_admin_btn").on("click",function () {
                let data = $('#add_admin_form').serialize();
                $.ajax({
                    type:"POST",
                    url:"/backend/admin/add",
                    data:data,
                    dataType:"json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        alert('添加成功');
                        window.location.reload();
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
            });


        });
    </script>
@stop

