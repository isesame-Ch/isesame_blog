
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
                        <li>文章管理</li>
                        <li class="active">分类管理</li>
                    </ul>
                    <!--breadcrumbs end -->
                    <h1 class="h1">分类管理</h1>
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
                                    <lable for="name">分类名：</lable>
                                    <input type="text" class="form-control" id="category_name" name="name" autocomplete="off">
                                </div>
                                {{--<div class="form-group col-md-offset-1">--}}
                                {{--<lable for="article_author">作者:</lable>--}}
                                {{--<input type="text" class="form-control" id="article_author" name="article_author" autocomplete="off">--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-offset-1">--}}
                                {{--<label for="category_id" class="control-label">父级分类:</label>--}}
                                {{--<select name="category_id" id="category_id" class="form-control category_select">--}}
                                {{--<option value="">--</option>--}}
                                {{--</select>--}}
                                {{--</div>--}}
                                <div class="form-group col-md-offset-1">
                                    <button type="button" class="btn btn-primary btn-trans form-control" id="search_btn">搜索</button>
                                </div>
                            </form>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#formModal" style="margin-top: 5px">添加</button>
                        </div>
                    </div>
                    <!-- Form Modal -->
                    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">添加分类</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" role="form" id="add_form">
                                        <div class="form-group">
                                            <label for="parent_id" class="col-sm-2 control-label">父级分类:</label>
                                            <div class="col-sm-10">
                                                <select name="parent_id" id="new_parent" class="form-control category_select" >
                                                    <option value="0" selected = "selected" >--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 control-label">分类名</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name" id="new_name" placeholder="分类名">
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="add_btn">添加</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                                    <h4 class="modal-title" id="myModalLabel">编辑分类信息</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" role="form" id="edit_form">
                                        <div class="form-group">
                                            <label for="category_id" class="col-sm-2 control-label">ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="category_id" id="edit_id" placeholder="ID" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="parent_id" class="col-sm-2 control-label">分类:</label>
                                            <div class="col-sm-10">
                                                <select name="parent_id" id="edit_parent_id" class="form-control category_select">
                                                    <option value="0" selected = "selected" >--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 control-label">分类名</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name" id="edit_category_name" placeholder="分类名称" >
                                            </div>
                                        </div>
                                        {{--<div class="form-group">--}}
                                            {{--<label class="col-sm-2 control-label">状态</label>--}}
                                            {{--<div class="col-sm-10">--}}
                                                {{--<label class="radio-inline">--}}
                                                    {{--<input class="icheck" type="radio" value="1" name="state" id="state1">禁用</label>--}}
                                                {{--<label class="radio-inline">--}}
                                                    {{--<input class="icheck" type="radio" value="2" name="state" id="state2">启用</label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
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
                            <span class="panel-title">分类列表</span>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover" id="category_list">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="display:none">id</th>
                                    <th style="display:none">父级id</th>
                                    <th>分类名</th>
                                    {{--<th>状态</th>--}}
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
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
            let page = 1;
            let page_size = 10;

            //获取分类列表
            function getCategoryList(){
                $.ajax({
                    type:'GET',
                    url:'/backend/article/category/all',
                    data:{},
                    dataType:'json',
                    success:function (data) {
                        if (data.code == 0) {
                            let list = data.content;
                            list.forEach(function ($item) {
                                $(".category_select").append(
                                    "<option value='"+$item.id+"'>"+$item.name+"</option>"
                                )
                            });
                        } else {
                            $("#search_alert").removeClass("hidden");
                            $("#search_alert span").html("<strong>出错喽~！"+data.message+"</strong>");
                        }
                    },
                    error:function (e) {
                        $("#search_alert").removeClass("hidden");
                        $("#search_alert span").html("<strong>出错喽~！</strong>");
                        if (typeof e.responseJSON.errors !== 'undefined') {
                            for($item in e.responseJSON.errors) {
                                $("#search_alert span").html($item + "格式不符合要求");
                            }
                        }
                    }
                })
            };

            //获取文章分类列表
            function getList(page=1,page_size=10){
                let data = $("#search_form").serialize();
                let _page = page;
                let _page_size = page_size;
                data = data+"&page="+_page+"&page_size="+_page_size;

                $.ajax({
                    type:'GET',
                    url:'/backend/article/category/list',
                    data:data,
                    dataType:'json',
                    success:function (data) {
                        if (data.code == 0) {
                            //清空表格和分页
                            $("#category_list tbody").html('');
                            $("#category_list ul").remove();

                            //显示分页栏
                            $("#category_list").append(
                                "<ul class=\"pagination \">\n" +
                                "<li><a href=\"javascript:void(0)\" class='pagination_a'>&laquo;</a></li>\n" +
                                "</ul>"
                            );
                            for ($i=1;$i<=data.content.total_page;$i++){
                                $("#category_list ul").append(
                                    "<li><a href=\"javascript:void(0)\" class='pagination_a'>"+$i+"</a></li>\n"
                                );
                            }
                            $("#category_list ul").append(
                                "<li><a href=\"javascript:void(0)\" class='pagination_a'>&raquo;</a></li>"
                            );
                            $lis = $("#category_list ul li");
                            $lis[data.content.current_page].className = 'active';

                            //加载表格
                            $list = data.content.list;
                            $i=1;
                            $list.forEach(function ($item) {
                                $("#category_list tbody").append(
                                    "<tr>" +
                                    "<td class=\"num\">"+$i+"</td>" +
                                    "<td class=\"id\" style=\"display:none\">"+$item.id+"</td>" +
                                    "<td class=\"parent_id\" style=\"display:none\">"+$item.parent_id+"</td>" +
                                    "<td class=\"name\">"+$item.name+"</td>" +
                                    // "<td class=\"state\">"+$item.state+"</td>" +
                                    "<td class=\"created_time\">"+$item.created_at+"</td>" +
                                    "<td>" +
                                    "<button class=\"btn btn-primary btn-sm edit_btn\" style=\"margin-left: 5px\" data-toggle=\"modal\" data-target=\"#updateModal\">编辑</button>" +
                                    // "<button class=\"btn btn-danger btn-sm delete_btn\" style=\"margin-left: 5px\">删除</button>" +
                                    "</td>" +
                                    "</tr>"
                                );
                                $i++;
                            })
                        } else {
                            $("#search_alert").removeClass("hidden");
                            $("#search_alert span").html("<strong>出错喽~！"+data.message+"</strong>");
                        }
                    },
                    error:function (e) {
                        $("#search_alert").removeClass("hidden");
                        $("#search_alert span").html("<strong>出错喽~！</strong>");
                        if (typeof e.responseJSON.errors !== 'undefined') {
                            for($item in e.responseJSON.errors) {
                                $("#search_alert span").html($item + "格式不符合要求");
                            }
                        }
                    }
                });
            };

            //加载添加分类表单中的列表
            getCategoryList();

            //加载获取列表
            getList(page,page_size);

            //搜索
            $("#search_btn").on("click",function () {
                getList(page,page_size);
            });

            //分页请求
            $("#category_list").on('click','.pagination_a',function(){
                let _this = $(this);
                let _page = _this[0].innerText;
                if (_page === '«') {
                    _page = 1;
                }else if (_page === '»') {
                    //最后一页
                    _page = _this.parent().parent().children('li').length-2;
                }
                getList(_page,page_size);
            });

            //提交编辑
            $("#category_list").on("click",'.edit_btn',function () {
                let td = $(this).parent().parent().children('td');
                let id = td[1].innerText;
                let parent_id = td[2].innerText;
                let category_name = td[3].innerText;
                // let state = td[4].innerText;
                // state == '启用' ? state = 2 : state = 1;

                $("#edit_id").val(id);
                $("#edit_parent_id").val(parent_id);
                $("#edit_category_name").val(category_name);
                $("#state"+state).attr('checked',true);
            });

            $("#update_btn").on("click",function () {
                let data = $("#edit_form").serialize();

                $.ajax({
                    url:'/backend/article/category/edit',
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
                            alert('编辑失败：'+data.message);
                        }
                    },
                    error:function (e) {
                        $("#search_alert").removeClass("hidden");
                        $("#search_alert span").html("<strong>出错喽~！</strong>");
                        if (typeof e.responseJSON.errors !== 'undefined')
                        {
                            for($item in e.responseJSON.errors) {
                                $("#search_alert span").html($item + "格式不符合要求");
                            }
                        }
                    }
                })
            });

            //删除文章分类
            $("#category_list").on("click",'.delete_btn',function () {
                let td = $(this).parent().parent().children('td');
                let id = td[1].innerText;
                $.ajax({
                    url:'/backend/article/category/delete',
                    type:'post',
                    data:{'category_id':id},
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
                        $("#search_alert").removeClass("hidden");
                        $("#search_alert span").html("<strong>出错喽~！</strong>");
                        if (typeof e.responseJSON.errors !== 'undefined')
                        {
                            for($item in e.responseJSON.errors) {
                                $("#search_alert span").html($item + "格式不符合要求");
                            }
                        }
                    }
                })
            });

            //添加分类
            $("#add_btn").on('click',function () {
                let data = $("#add_form").serialize();

                $.ajax({
                    type:'POST',
                    url:'/backend/article/category/add',
                    data:data,
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.code == 0) {
                            alert('添加成功');
                            window.location.reload();
                        } else {
                            alert('出错喽~！' + data.message);
                        }
                    },
                    error:function (e) {
                        $("#search_alert").removeClass("hidden");
                        $("#search_alert span").html("<strong>出错喽~！</strong>");
                        if (typeof e.responseJSON.errors !== 'undefined')
                        {
                            for($item in e.responseJSON.errors) {
                                $("#search_alert span").html($item + "格式不符合要求");
                            }
                        }
                    }
                });

            })


        });
    </script>
@stop

