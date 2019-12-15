<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="author" content="order by dede58.com"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>芝麻小站后台</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/js/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Fonts from Font Awsome -->
    <link rel="stylesheet" href="/css/backend/font-awesome.min.css">
    <!-- CSS Animate -->
    <link rel="stylesheet" href="/css/backend/animate.css">
    <!-- Custom styles for this theme -->
    <link rel="stylesheet" href="/css/backend/main.css">
@section('css')
@show
<!-- Fonts -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'> -->
    <!-- Feature detection -->
    <script src="/js/backend/modernizr-2.6.2.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/js/backend/html5shiv.js"></script>
    <script src="/js/backend/respond.min.js"></script>
    <![endif]-->
</head>

@section('body')
    <body>
    <section id="container">
        @section('header')
            <header id="header">
                <!--logo start-->
                <div class="brand">
                    <a href="/backend/index" class="logo">
                        <span>博客后台管理</span></a>
                </div>
                <!--logo end-->
                <div class="toggle-navigation toggle-left">
                    <button type="button" class="btn btn-default" id="toggle-left" data-toggle="tooltip" data-placement="right" title="Toggle Navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="user-nav">
                    <ul id="user_ul"> </ul>
                </div>
            </header>
        @show

        @section('sidebar_left')
        <!--sidebar left start-->
            <aside class="sidebar">
                <div id="leftside-navigation" class="nano">
                    <ul class="nano-content">
                        <li>
                            <a href="/backend/index"><i class="fa fa-dashboard"></i><span>站点统计</span></a>
                        </li>
                        <li class="sub-menu hidden" id="menu_user">
                            <a href="javascript:void(0);"><i class="fa fa-cogs"></i><span>用户管理</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                            <ul>
                                <li>
                                    <a href="/backend/user/show">用户列表</a>
                                </li>
                                <li>
                                    <a href="/backend/admin/list">权限列表</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-menu hidden" id="menu_article">
                            <a href="javascript:void(0);"><i class="fa fa-table"></i><span>文章管理</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                            <ul>
                                <li>
                                    <a href="/backend/article/show">文章发布</a>
                                </li>
                                <li>
                                    <a href="/backend/article/list/show">文章列表</a>
                                </li>
                                <li>
                                    <a href="/backend/article/category/show">分类管理</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-menu hidden" id="menu_system">
                            <a href="javascript:void(0);"><i class="fa fa fa-tasks"></i><span>系统配置</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                            <ul>
                                <li>
                                    <a href="forms-components.html">Components</a>
                                </li>
                                <li>
                                    <a href="forms-validation.html">Validation</a>
                                </li>
                                <li>
                                    <a href="forms-mask.html">Mask</a>
                                </li>
                                <li>
                                    <a href="forms-wizard.html">Wizard</a>
                                </li>
                                <li>
                                    <a href="forms-multiple-file.html">Multiple File Upload</a>
                                </li>
                                <li>
                                    <a href="forms-wysiwyg.html">WYSIWYG Editor</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-menu" id="menu_log">
                            <a href="javascript:void(0);"><i class="fa fa-envelope"></i><span>访问日志</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                            <ul>
                                <li>
                                    <a href="mail-inbox.html">Inbox</a>
                                </li>
                                <li>
                                    <a href="mail-compose.html">Compose Mail</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </aside>
            <!--sidebar left end-->
        @show

        @section('main_content')
        @show
    </section>

    <!--Global JS-->
    <script src="/js/backend/jquery-1.10.2.min.js"></script>
    <script src="/js/jquery.cookie.js"></script>
    <script src="/js/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/plugins/waypoints/waypoints.min.js"></script>
    <script src="/js/backend/application.js"></script>
    <script>
        //判断权限
        if ($.cookie('admin-user') && JSON.parse($.cookie('admin-user'))['identity'] !== 1)
        {
            $("#menu_user").removeClass('hidden');
            $("#menu_article").removeClass('hidden');
            $("#menu_system").removeClass('hidden');
        }

        //监听变化，cookie过期就重新登录
        window.onchange = function () {
            if (!$.cookie('admin-user') || $.cookie('admin-user') == null ){
                window.location = '/backend/login';
            }
        };
        $("body").on('click','button',function () {
            if (!$.cookie('admin-user') || $.cookie('admin-user') == null ){
                window.location = '/backend/login';
            }
        });
        $("body").on('click','input',function () {
            if (!$.cookie('admin-user') || $.cookie('admin-user') == null ){
                window.location = '/backend/login';
            }
        });
        $("body").on('click','a',function () {
            if (!$.cookie('admin-user') || $.cookie('admin-user') == null ){
                window.location = '/backend/login';
            }
        });

        //加载用户头像或登陆按钮
        if ($.cookie('admin-user')) {
            $("#user_ul").html(
                '<li class="profile-photo">\n' +
                '    <img src="/uploads'+JSON.parse($.cookie('admin-user')).head_pic+'" alt="" style="width: 25px;height:25px" class="img-circle" id="admin_head_pic">\n' +
                '</li>\n' +
                '<li class="dropdown settings">\n' +
                '    <a class="dropdown-toggle" data-toggle="dropdown" href="#">\n' +
                '        '+JSON.parse($.cookie('admin-user')).nickname+'\n' +
                '        <i class="fa fa-angle-down"></i>\n' +
                '    </a>\n' +
                '    <ul class="dropdown-menu animated fadeInDown">\n' +
                '        <li>\n' +
                '             <a href="javascript:void(0)" id="logOut"><i class="fa fa-power-off"></i> 退出</a>\n' +
                '        </li>\n' +
                '    </ul>\n' +
                '</li>'
            )
        } else {
            window.location = '/backend/login';
        }

        //退出登陆
        $("#logOut").on('click',function () {
            $.ajax({
                type:"POST",
                url:"/backend/logout",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:'',
                dataType:"json",
                success:function (data) {
                    if (data.code == 0)
                    {
                        $.cookie('admin-user',null, { expires: -1 });
                        alert('拜拜~');
                        window.location = '/backend/login';
                    } else {
                        alert(data.message);
                    }
                },
                error: function (e) {
                    if(e.responseJSON.message) {
                        alert(e.responseJSON.message);
                    }
                }
            })

        })
    </script>

    @section('js')
    @show
    </body>
@show




</html>