
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
                        <li class="active">文章列表</li>
                    </ul>
                    <!--breadcrumbs end -->
                    <h1 class="h1">文章列表</h1>
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
                                    <lable for="article_name">标题:</lable>
                                    <input type="text" class="form-control" id="article_name" name="article_name" autocomplete="off">
                                </div>
                                <div class="form-group col-md-offset-1">
                                    <lable for="article_author">作者:</lable>
                                    <input type="text" class="form-control" id="article_author" name="article_author" autocomplete="off">
                                </div>
                                <div class="form-group col-md-offset-1">
                                    <label for="category_id" class="control-label">分类:</label>
                                    <select name="category_id" id="category_id" class="form-control category_select">
                                        <option value="">--</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-offset-1">
                                    <button type="button" class="btn btn-primary btn-trans form-control" id="search_btn">搜索</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
                                    <h4 class="modal-title" id="myModalLabel">编辑文章信息</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" role="form" id="edit_form">
                                        <div class="form-group">
                                            <label for="article_id" class="col-sm-2 control-label">ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="article_id" id="edit_id" placeholder="ID" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="article_name" class="col-sm-2 control-label">标题</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="article_name" id="edit_article_name" placeholder="文章标题" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="article_author" class="col-sm-2 control-label">作者</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="article_author" id="edit_article_author" placeholder="文章作者" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id" class="col-sm-2 control-label">分类:</label>
                                            <div class="col-sm-10">
                                                <select name="category_id" id="edit_category" class="form-control category_select"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">是否公开</label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input class="icheck" type="radio" value="1" name="article_type" id="article_type1">公开</label>
                                                <label class="radio-inline">
                                                    <input class="icheck" type="radio" value="2" name="article_type" id="article_type2">私有</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">是否推荐</label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input class="icheck" type="radio" value="1" name="article_support" id="article_support1">否</label>
                                                <label class="radio-inline">
                                                    <input class="icheck" type="radio" value="2" name="article_support" id="article_support2">是</label>
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
                            <span class="panel-title">文章列表</span>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover" id="article_list">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="display:none">id</th>
                                    <th>标题</th>
                                    <th>作者</th>
                                    <th style="display: none;">分类id</th>
                                    <th>分类</th>
                                    <th>浏览量</th>
                                    <th>发布时间</th>
                                    <th style="display: none;">是否公开</th>
                                    <th style="display: none;">是否推荐</th>
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
            var page = 1;
            var page_size = 10;

            //获取分类列表
            function getCategoryList(){
                $.ajax({
                    type:'GET',
                    url:'/backend/article/category/all',
                    data:'',
                    dataType:'json',
                    success:function (data) {
                        if (data.code == 0) {
                            var list = data.content;
                            list.forEach(function ($item) {
                                $(".category_select").append(
                                    "<option value='"+$item.id+"'>"+$item.name+"</option>"
                                )
                            });
                        } else {
                            $("#search_alert").removeClass("hidden");
                            $("#search_alert span").html("<strong>出错喽~！</strong>");
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

            //获取文章列表
            function getList(page=1,page_size=10){
                var data = $("#search_form").serialize();

                var _page = page;
                var _page_size = page_size;
                data = data+"&page="+_page+"&page_size="+_page_size;

                $.ajax({
                    type:'get',
                    url:'/backend/article/getlist',
                    data:data,
                    dataType:'json',
                    success:function (data) {
                        if (data.code == 0)
                        {
                            //清空表格和分页
                            $("#article_list tbody").html('');
                            $("#article_list ul").remove();

                            //显示分页栏
                            $("#article_list").append(
                                "<ul class=\"pagination \">\n" +
                                "<li><a href=\"javascript:void(0)\" class='pagination_a'>&laquo;</a></li>\n" +
                                "</ul>"
                            );
                            for ($i=1;$i<=data.content.total_page;$i++){
                                $("#article_list ul").append(
                                    "<li><a href=\"javascript:void(0)\" class='pagination_a'>"+$i+"</a></li>\n"
                                );
                            }
                            $("#article_list ul").append(
                                "<li><a href=\"javascript:void(0)\" class='pagination_a'>&raquo;</a></li>"
                            );
                            $lis = $("#article_list ul li");
                            $lis[data.content.current_page].className = 'active';

                            //加载表格
                            $list = data.content.list;
                            $i=1;
                            $list.forEach(function ($item) {
                                $item.created_at = $item.created_at;
                                $("#article_list tbody").append(
                                    "<tr>" +
                                    "<td class=\"num\">"+$i+"</td>" +
                                    "<td class=\"article_id\" style=\"display:none\">"+$item.id+"</td>" +
                                    "<td class=\"article_name\">"+$item.article_name+"</td>" +
                                    "<td class=\"article_author\">"+$item.article_author+"</td>" +
                                    "<td class=\"category_id\" style=\"display:none\">"+$item.category_id+"</td>" +
                                    "<td class=\"category_name\">"+$item.category_name+"</td>" +
                                    "<td class=\"article_view\">"+$item.article_view+"</td>" +
                                    "<td class=\"created_time\">"+$item.created_at+"</td>" +
                                    "<td class=\"article_type\" style=\"display:none\">"+$item.article_type+"</td>" +
                                    "<td class=\"article_support\" style=\"display:none\">"+$item.article_support+"</td>" +
                                    "<td>" +
                                    "<button class=\"btn btn-info btn-sm detail_btn\" style=\"margin-left: 5px\">详情</button>" +
                                    "<button class=\"btn btn-primary btn-sm edit_btn\" style=\"margin-left: 5px\" data-toggle=\"modal\" data-target=\"#updateModal\">编辑</button>" +
                                    "<button class=\"btn btn-warning btn-sm delete_btn\" style=\"margin-left: 5px\">删除</button>" +
                                    "<button class=\"btn btn-danger btn-sm remove_btn\" style=\"margin-left: 5px\">移除</button>" +
                                    "</td>" +
                                    "</tr>"
                                );
                                $i++;
                            })
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
            };

            //加载分类列表
            getCategoryList();

            //加载获取列表
            getList(page,page_size);

            //搜索
            $("#search_btn").on("click",function () {
                getList(page,page_size);
            });

            //分页请求
            $("#article_list").on('click','.pagination_a',function(){
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
            $("#article_list").on("click",'.edit_btn',function () {
                var td = $(this).parent().parent().children('td');
                var id = td[1].innerText;
                var article_name = td[2].innerText;
                var article_author = td[3].innerText;
                var category_id = td[4].innerText;
                var article_type = td[8].innerText;
                var article_support = td[9].innerText;

                $("#edit_id").val(id);
                $("#edit_article_name").val(article_name);
                $("#edit_article_author").val(article_author);
                $("#edit_category").val(category_id);
                $("#article_type"+article_type).attr('checked',true);
                $("#article_support"+article_support).attr('checked',true);
            });

            $("#update_btn").on("click",function () {
                var data = $("#edit_form").serialize();

                $.ajax({
                    url:'/backend/article/edit',
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
                            alert('出错喽~！'+data.message);
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

            //删除文章
            $("#article_list").on("click",'.delete_btn',function () {
                var td = $(this).parent().parent().children('td');
                var id = td[1].innerText;
                $.ajax({
                    url:'/backend/article/delete',
                    type:'post',
                    data:{'article_id':id},
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

            //彻底删除文章
            $("#article_list").on("click",'.remove_btn',function () {
                $confirm = confirm("彻底移除后没有办法找回记录，确认删除？");
                if($confirm === false) {return false;};

                var td = $(this).parent().parent().children('td');
                var id = td[1].innerText;
                $.ajax({
                    url:'/backend/article/remove',
                    type:'post',
                    data:{'article_id':id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:"json",
                    success:function (data) {
                        if (data.code == 0) {
                            alert('彻底移除');
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

            //点击详情跳转编辑内容页面
            $("#article_list").on("click",'.detail_btn',function () {
                var td = $(this).parent().parent().children('td');
                var id = td[1].innerText;

                window.location = '/backend/article/edit/'+id;
            });





        });
    </script>
@stop

