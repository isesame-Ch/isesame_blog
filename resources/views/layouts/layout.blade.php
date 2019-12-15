<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>西山小站</title>
    <!-- Le styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,body {
            margin: 0;
            padding: 0;
        }
        nav {
            z-index: 9999;
        }
        nav .navbar-collapse{
            background-color: #0f0f0f
        }
        .logo_img {
            width: 120px;
            height: 40px;
            margin-top: 5px;
        }
        #dropdown_btn {
            margin-top: 7.5px;;
        }
        #dropdown_btn,.dropdown-menu {
            background-color: #0f0f0f;
        }
        .dropdown-menu .drop-btn {
            color: #fefefe;
        }
        .dropdown-menu .drop-btn:hover {
            color: #0f0f0f;
            background-color: #f5f5f5;
        }
        #body_container {
            background-color: #fefefe;
            margin-top: 60px;
        }
        #nav_head_pic {
            display: inline-block;
            height: 50px;
            line-height: 50px;
        }
        #upToTOP {
            border-radius: 50px;
            background-color: #e94141;
            height: 50px;
            width: 50px;
            position: fixed;
            bottom: 100px;
            right: 50px;
            text-align: center;
            line-height: 50px;
            font-size: 20px;
            z-index: 9999;
        }

        /*
       博主简介栏目
       */
        #user_info {
            padding: 0;
            margin:10px 0;
            background-color: rgba(255,255,255,0.8);
        }
        #user_info_head {
            margin: 15px auto;
            width: 100px;
            height: 100px;
        }
        .user_head_img {
            border-radius: 50px;
        }
        #user_detail {
            margin-top: 10px;
            background-color: #fff;
        }
        #user_info_ul {
            list-style: none;
            padding: 0;
            height: 70px;
            margin-bottom: 0;
        }
        #user_info_ul li {
            float: left;
            text-align: center;
            vertical-align: middle;
            width: 33%;
            height: 70px;
            font-size: 12px;
            padding: 0 5px;
        }
        #user_info_ul li:first-child,#user_info_ul li:nth-child(2) {
            border-right: 1px #eee solid;
        }
        #user_info_ul li span {
            font-size: 22px;
            display: inline-block;
            width: 100%;
            border-bottom: 2px #000 solid;
            margin-bottom: 10px;
        }
        #introduction {
            margin-top: 20px;
            text-align: center;
            font-size: 22px;
        }
        #introduction_content {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        /*
       推荐栏目
       */
        #recommend_container {
            height: 500px;
            background-color: rgba(255,255,255,0.8);
            margin:50px 0;
            float: right;
        }
        #recommend_container h3 {
            font-size: 22px;
            text-align: center;
            border-left: 5px #d63f3f solid;
        }
        .recommend_ul {
            list-style: none;
            font-size: 18px;
            margin-top: 20px;
            padding: 0;
            clear: both;
        }
        .recommend_li {
            margin-top: 12px;
            line-height: 30px;
            border-bottom: 1px #ccc solid;
            text-decoration: none;
            text-align: center;
        }
        .recommend_li a {
            color: #333;
            text-decoration: none;
        }
        .recommend_li a:nth-child(2n-1) {
            color: #333;
        }
        .recommend_li a:visited  {
            color: #333;
            text-decoration: none;
        }
        .recommend_li a:hover {
            color: #d63f3f;
            text-decoration: none;
        }
        .recommend_li a span {
            font-size: 12px;
            float: right;
        }
        .recommend_li p.article_title{
            width: 80%;
            display: inline-block;
            overflow: hidden;
            text-overflow:ellipsis;
            white-space: nowrap;
        }
        footer {
            background-color: #0f0f0f;
        }
        footer .container {
            height: 200px;
        }
        @media screen and (max-width: 767px) {
            #logo_a {
                margin-left: 5%;
            }
            #J_dotLine {
                display: none;
            }
            #user_info {
                display: none;
            }
            #recommend_container {
                display: none;
            }
        }
        @media screen and (min-width: 768px) and (max-width: 992px) {
            #nav_head_pic {
                display: inline-block;
                height: 50px;
                line-height: 50px;
            }
            #J_dotLine {
                display: none;
            }
            #user_info {
                display: none;
            }
            #recommend_container {
                display: none;
            }
        }
        @media screen and (min-width: 993px) and (max-width: 1200px) {
            #nav-div {
                padding-right: 10%;
            }
            #nav_head_pic {
                display: inline-block;
                height: 50px;
                line-height: 50px;
            }
            #user_info {
                display: none;
            }
            #recommend_container {
                display: none;
            }
        }
        @media screen and (min-width: 1200px) {
            #nav-div {
                padding-right: 10%;
            }
            #nav_head_pic {
                display: inline-block;
                height: 50px;
                line-height: 50px;
            }
            .drop-btn {
                color: #fefefe;
            }
        }

    </style>
    @section('style')
        @show
</head>
<body>
    @section('header')
        <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #0f0f0f;height: 51px">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="" href="/index" id="logo_a">
                        <img src="/img/logo.png" class="logo_img" title="建议设置240*40的图像" style="width: 240px;height: 40px"/>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <div class="navbar-right" id="nav-div">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="/index" style="color: #fefefe;">
                                    首页
                                </a>
                            </li>
                            <li>
                                <a href="about.html" style="color: #fefefe;">
                                    关于
                                </a>
                            </li>
                            <li>
                                <a href="blog.html" style="color: #fefefe;">
                                    博客
                                </a>
                            </li>
                            <li>
                                <a href="works.html" style="color: #fefefe;">
                                    作品
                                </a>
                            </li>
                            <li>
                                <a href="/game" style="color: #fefefe;">
                                    游戏
                                </a>
                            </li>
                            <li>
                                <a href="contact.html" style="color: #fefefe;">
                                    联系
                                </a>
                            </li>
                            <li>
                                <a href="help.html" style="color: #fefefe;">
                                    帮助
                                </a>
                            </li>
                        </ul>


                        <div class="nav navbar-nav navbar-right">
                            <li class="dropdown" id="nav_head_pic">
                            </li>
                        </div>

                    </div>


                </div>
            </div>
        </nav>
    @show
    <div id="toTop" style="visibility: hidden"></div>

    @section('up_top')
        <div id="upToTOP">
            <a href="#toTop" style="color: #fefefe;" class="glyphicon glyphicon-upload"></a>
        </div>
    @show

    @section('bg_canvas')
        <canvas id="J_dotLine" style="background-color: #fefefe;position: fixed;z-index: 0;"></canvas>
        <script>
            (function(window){
                function Dotline(option){
                    this.opt = this.extend({
                        dom:'J_dotLine',//画布id
                        cw: 1000,//画布宽
                        ch:1000,//画布高
                        ds:100,//点的个数
                        r:0.5,//圆点半径
                        cl:'#000',//颜色
                        dis:50//触发连线的距离
                    },option);
                    this.c = document.getElementById(this.opt.dom);//canvas元素id
                    this.ctx = this.c.getContext('2d');
                    this.c.width = this.opt.cw;//canvas宽
                    this.c.height = this.opt.ch;//canvas高
                    this.dotSum = this.opt.ds;//点的数量
                    this.radius = this.opt.r;//圆点的半径
                    this.disMax = this.opt.dis*this.opt.dis;//点与点触发连线的间距
                    this.color = this.color2rgb(this.opt.cl);//设置粒子线颜色
                    this.dots = [];
                    //requestAnimationFrame控制canvas动画
                    var RAF = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function(callback) {
                        window.setTimeout(callback, 1000 / 60);
                    };
                    var _self = this;
                    //增加鼠标效果
                    var mousedot = {x:null,y:null,label:'mouse'};
                    this.c.onmousemove = function(e){
                        var e = e || window.event;
                        mousedot.x = e.clientX - _self.c.offsetLeft;
                        mousedot.y = e.clientY - _self.c.offsetTop;
                    };
                    this.c.onmouseout = function(e){
                        mousedot.x = null;
                        mousedot.y = null;
                    };
                    //控制动画
                    this.animate = function(){
                        _self.ctx.clearRect(0, 0, _self.c.width, _self.c.height);
                        _self.drawLine([mousedot].concat(_self.dots));
                        RAF(_self.animate);
                    };
                }
                //合并配置项，es6直接使用obj.assign();
                Dotline.prototype.extend = function(o,e){
                    for(var key in e){
                        if(e[key]){
                            o[key]=e[key]
                        }
                    }
                    return o;
                };
                //设置线条颜色(参考{抄袭}张鑫旭大大，http://www.zhangxinxu.com/wordpress/2010/03/javascript-hex-rgb-hsl-color-convert/)
                Dotline.prototype.color2rgb = function(colorStr){
                    var red = null,
                        green = null,
                        blue = null;
                    var cstr = colorStr.toLowerCase();//变小写
                    var cReg = /^#[0-9a-fA-F]{3,6}$/;//确定是16进制颜色码
                    if(cstr&&cReg.test(cstr)){
                        if(cstr.length==4){
                            var cstrnew = '#';
                            for(var i=1;i<4;i++){
                                cstrnew += cstr.slice(i,i+1).concat(cstr.slice(i,i+1));
                            }
                            cstr = cstrnew;
                        }
                        red = parseInt('0x'+cstr.slice(1,3));
                        green = parseInt('0x'+cstr.slice(3,5));
                        blue = parseInt('0x'+cstr.slice(5,7));
                    }
                    return red+','+green+','+blue;
                }
                //画点
                Dotline.prototype.addDots = function(){
                    var dot;
                    for(var i=0; i<this.dotSum; i++){//参数
                        dot = {
                            x : Math.floor(Math.random()*this.c.width)-this.radius,
                            y : Math.floor(Math.random()*this.c.height)-this.radius,
                            ax : (Math.random() * 2 - 1) / 1.5,
                            ay : (Math.random() * 2 - 1) / 1.5
                        }
                        this.dots.push(dot);
                    }
                };
                //点运动
                Dotline.prototype.move = function(dot){
                    dot.x += dot.ax;
                    dot.y += dot.ay;
                    //点碰到边缘返回
                    dot.ax *= (dot.x>(this.c.width-this.radius)||dot.x<this.radius)?-1:1;
                    dot.ay *= (dot.y>(this.c.height-this.radius)||dot.y<this.radius)?-1:1;
                    //绘制点
                    this.ctx.beginPath();
                    this.ctx.arc(dot.x, dot.y, this.radius, 0, Math.PI*2, true);
                    this.ctx.stroke();
                };
                //点之间画线
                Dotline.prototype.drawLine = function(dots){
                    var nowDot;
                    var _that = this;
                    //自己的思路：遍历两次所有的点，比较点之间的距离，函数的触发放在animate里
                    this.dots.forEach(function(dot){

                        _that.move(dot);
                        for(var j=0; j<dots.length; j++){
                            nowDot = dots[j];
                            if(nowDot===dot||nowDot.x===null||nowDot.y===null) continue;//continue跳出当前循环开始新的循环
                            var dx = dot.x - nowDot.x,//别的点坐标减当前点坐标
                                dy = dot.y - nowDot.y;
                            var dc = dx*dx + dy*dy;
                            if(Math.sqrt(dc)>Math.sqrt(_that.disMax)) continue;
                            // 如果是鼠标，则让粒子向鼠标的位置移动
                            if (nowDot.label && Math.sqrt(dc) >Math.sqrt(_that.disMax)/2) {
                                dot.x -= dx * 0.02;
                                dot.y -= dy * 0.02;
                            }
                            var ratio;
                            ratio = (_that.disMax - dc) / _that.disMax;
                            _that.ctx.beginPath();
                            _that.ctx.lineWidth = ratio / 2;
                            _that.ctx.strokeStyle = 'rgba('+_that.color+',' + parseFloat(ratio + 0.2).toFixed(1) + ')';
                            _that.ctx.moveTo(dot.x, dot.y);
                            _that.ctx.lineTo(nowDot.x, nowDot.y);
                            _that.ctx.stroke();//不描边看不出效果

                            //dots.splice(dots.indexOf(dot), 1);
                        }
                    });
                };
                //开始动画
                Dotline.prototype.start = function(){
                    var _that = this;
                    this.addDots();
                    setTimeout(function() {
                        _that.animate();
                    }, 100);
                }
                window.Dotline = Dotline;
            }(window));
            //调用
            window.onload = function(){
                var footerHeight = window.getComputedStyle(document.getElementById("footer")).height;
                var bodyContainerHeight = document.getElementById("body_container");
                // var marginTop = bodyContainerHeight.style.marginTop;
                var marginTop = 60;
                footerHeight = footerHeight.replace("px", "");
                // marginTop = marginTop.replace("px", "");
                var dotline = new Dotline({
                    dom:'J_dotLine',//画布id
                    cw:window.screen.width,//画布宽
                    ch:document.documentElement.clientHeight-footerHeight-marginTop,//画布高
                    ds:100,//点的个数
                    r:0.5,//圆点半径
                    cl:'#d63f3f',//粒子线颜色
                    dis:100//触发连线的距离
                }).start();
            }
        </script>
    @show

    <div class="container" id="body_container">
        @section('body_container')
        @show
        @section('user_sidebar')
            <div class="sidebar col-lg-4" id="user_info">
                <div id="user_info_head">
                    <img src="/img/introduction_head_pic.jpg" class="user_head_img" alt="" style="width: 100px;height: 100px;">
                </div>
                <div class="col-lg-12" id="user_detail">
                    <ul class="col-lg-12" id="user_info_ul">
                        <li class="col-lg-4">
                            <span>110</span>
                            会员数
                        </li>
                        <li class="col-lg-4">
                            <span>110</span>
                            文章数
                        </li>
                        <li class="col-lg-4">
                            <span>110</span>
                            标签总数
                        </li>
                    </ul>
                </div>
                <div class="col-lg-12" id="introduction">
                    <span id="introduction_title">个人简介</span>
                    <p id="introduction_content">
                        博主网名—XISHAN,现从事互联网工作，目前就职于 ~~~ 不想说 。本人的工作方向是PHP后台开发方面，不过也一直在学习前端开发和Linux服务器，比较喜欢的就是研究新技术，得跟上时代的脚步，不停的学习
                    </p>
                </div>
            </div>
        @show
        @section('recommend_sidebar')
            <div class="sidebar col-lg-4" id="recommend_container" >
                <h3>推荐文章</h3>
                <ul class="recommend_ul" id="support_list"></ul>
            </div>
        @show
    </div>

    @section('footer')
        <footer class="navbar-bottom" id="footer">
            <div class="container">
                {{--<p style="text-align: center;font-size: 60px">footer</p>--}}
                <ul style="color: #fefefe;list-style: none;margin: 50px auto">
                    <li style="border-right: 1px #fefefe solid;display: inline-block;width: 33%;text-align: center">Copyright© 2019-2099</li>
                    <li style="border-right: 1px #fefefe solid;display: inline-block;width: 33%;text-align: center"> Powered by XISHAN</li>
                    <li style="display: inline-block;width: 33%;text-align: center"> 粤ICP备19153692号-1</li>
                </ul>
            </div>
        </footer>
    @show


<!-- Le javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/jquery.cookie.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/validate-form.js"></script>
<!--Load transform timestamp-->
<script src="/js/timestamp-transform.js"></script>
<!--END transform timestamp-->
<script>
    //加载用户头像或登陆按钮
    if ($.cookie('user')) {
        $("#nav_head_pic").html(
            '<a href="#" class="dropdown-toggle" id="dropdown_btn" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="padding: 5px 15px;">' +
                '<img src="/uploads'+JSON.parse($.cookie('user')).head_pic+'" alt="" style="width: 25px;height: 25px;border-radius: 50px">' +
                '<span class="caret"></span>' +
            '</a>' +
            '<ul class="dropdown-menu">' +
                '<li id="drop-li">' +
                    '<a href="#" class="drop-btn">'+JSON.parse($.cookie('user')).nickname+'</a>' +
                '</li>' +
                '<li class="drop-li">' +
                    '<a href="#" id="sign_out_btn" class="drop-btn">退出登陆</a>' +
                '</li>' +
            '</ul>'
        )
    } else {
        $("#nav_head_pic").html('<a href="/login" target="_blank" style="color: #fefefe;">登陆</a>');
    }


    //退出登陆
    $("#sign_out_btn").on('click',function () {
        $.ajax({
            type:"POST",
            url:"/logout",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:'',
            dataType:"json",
            success:function (data) {
                if (data.code == 0)
                {
                    $.cookie('user',null, { expires: -1 });
                    alert('拜拜~');
                    window.location = ''+data.content.url+'';
                }else {
                    alert('退出失败：'+ data.message);
                }
            },
            error: function (e) {
                if (e.responseJSON.message) {
                    alert(e.responseJSON.message);
                }
                window.location = '/index';
            }
        })
    });
    
    // 获取推荐文章列表,加载推荐文章列表
    $(function () {
        $.ajax({
            type:'GET',
            url:'/article/support/list',
            data:{'article_support':2},
            dataType:'json',
            success:function (data) {
                if (data.code == 0) {
                    if (data.content.length > 0) {
                        $list = data.content;
                        $list.forEach(function ($item) {
                            $item.created_time = tsToDate('Y-m-d',$item.created_time);
                            $("#support_list").append(
                                " <li class=\"recommend_li\"><a href=\"/article/article_id/"+$item.id+"\"><p class=\"article_title\">"+$item.article_name+"</p><span>"+$item.created_at+"</span></a></li>"
                            )
                        })
                    }
                } else {
                    alert('出错喽~！' + data.message);
                }
            },
            error:function (e) {
                alert('出错喽~！');
            }
        })
    });

</script>
@section('js')
@show

</body>
</html>