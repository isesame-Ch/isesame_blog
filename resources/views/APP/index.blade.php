
@extends('layouts.layout')
@section('style')
    <style>
        .carousel-img {
            width: 100%;
        }
        /*
        文章列表样式
        */
        #article_ul {
            list-style: none;
            margin-top: 20px;
            padding: 0;
            clear: both;
        }
        .article_li {
            margin-top: 12px;
            line-height: 30px;
            border-bottom: 1px #ccc solid;
            text-decoration: none;
            height: 200px;
        }
        /*
        文章文字样式
        */
        .article_li a {
            color: #333;
            font-size: 22px;
            text-decoration: none;
        }
        .article_li a:link {
            color: #333;
            text-decoration: none;
        }
        .article_li a:visited  {
            color: #333;
            text-decoration: none;
        }
        .article_li a:hover {
            color: #d63f3f;
            text-decoration: none;
        }
        .article_li a span {
            font-size: 12px;
            float: right;
        }

        /*
        文章图片
         */
        .article_img {
            display: inline-block;
            width: 150px;
            height: 150px;
            vertical-align: middle;
            margin-top: 10px;
            transition: all 0.6s;
        }
        .article_img:hover {
            transform:rotate(7deg);
            -ms-transform:rotate(7deg); 	/* IE 9 */
            -moz-transform:rotate(7deg); 	/* Firefox */
            -webkit-transform:rotate(7deg); /* Safari 和 Chrome */
            -o-transform:rotate(7deg); 	/* Opera */
        }
        /*
        文章详情DIV
         */
        .article_detail {
            margin-left: 30px;
            display: inline-block;
            vertical-align: middle;
        }

        /*
        文章内容
         */
        .article_content {
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 14px;
            height: 84px;
            line-height: 21px;
            margin-top: 10px;
        }
        @media screen and (max-width: 767px) {
            .article_img {
                display: none;
            }
        }
        @media screen and (min-width: 768px) and (max-width: 992px) {
            .article_img {
                display: none;
            }
        }
        @media screen and (min-width: 993px) and (max-width: 1200px) {
            .article_img {
                display: none;
            }
        }
    </style>
    @stop
@section('body_container')
    <div style="width: 100%;">
        <div id="myCarousel" class="carousel slide">
            <!-- 轮播（Carousel）指标 -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <!-- 轮播（Carousel）项目 -->
            <div class="carousel-inner">
                <div class="item active">
                    <a href="#">
                        <img src="/img/carousel1.jpg" class="carousel-img" style="width: 1200px;height: 400px;" alt="First slide">
                    </a>
                </div>
                <div class="item">
                    <a href="#">
                        <img src="/img/carousel2.jpg" class="carousel-img" style="width: 1200px;height: 400px;" alt="Second slide">
                    </a>
                </div>
                <div class="item">
                    <a href="#">
                        <img src="/img/carousel3.jpg" class="carousel-img" style="width: 1200px;height: 400px;" alt="Third slide">
                    </a>
                </div>
            </div>
            <!-- 轮播（Carousel）导航 -->
            <a class="left carousel-control" style="background-image: none" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" style="background-image: none" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="sidebar col-lg-8" style="margin:10px 0;" id="article_list">
        <h3>最新文章</h3>
        <ul id="article_ul">
            <li style="width: 100%;height: 200px;background-color: #e7e7e7;margin-top: 12px;opacity:0.5"></li>
            <li style="width: 100%;height: 200px;background-color: #e7e7e7;margin-top: 12px;opacity:0.5"></li>
            <li style="width: 100%;height: 200px;background-color: #e7e7e7;margin-top: 12px;opacity:0.5"></li>
            <li style="width: 100%;height: 200px;background-color: #e7e7e7;margin-top: 12px;opacity:0.5"></li>
        </ul>
    </div>
    @stop
@section('js')
    <script>
        /*
         *轮播图
         */
        $(document).ready(function(){
            var startX,endX;//声明触摸的两个变量
            var offset = 30;//声明触摸距离的变量
            $('.carousel-inner').on('touchstart',function (e) {
                startX= e.originalEvent.touches[0].clientX;//当触摸开始时的x坐标；
            });
            $('.carousel-inner').on('touchmove',function (e) {
                endX = e.originalEvent.touches[0].clientX;//当触摸离开时的x坐标；
            });
            $('.carousel-inner').on('touchend',function (e) {
                //当触摸完成时进行的事件；
                var distance = Math.abs(startX - endX);//不论正负，取值为正值；
                if (distance > offset){
                    if(startX > endX){
                        $('#myCarousel').carousel('next');//当开始的坐标大于结束的坐标时，滑动到下一附图
                    }else{
                        $('#myCarousel').carousel('prev');//当开始的坐标小于结束的坐标时，滑动到上一附图

                    }

                }
            });
        });

        $('#myCarousel').carousel({
            interval: 3000
        })
    </script>
    <script>
        $(function(){

            getArticleList();

            function getArticleList(page=1,page_size=10) {
                var _page = page;
                var _page_size = page_size;
                var data = "&page="+_page+"&page_size="+_page_size;

                $.ajax({
                    type:'get',
                    url:'/article/getlist',
                    data:data,
                    dataType:'json',
                    success:function (data) {
                        if (data.code == 0) {
                            //清空表格和分页
                            $("#article_list .pagination").remove();
                            //清空表格和分页
                            $("#article_list ul li").remove();

                            //显示分页栏
                            $("#article_list").append(
                                "<ul class=\"pagination pull-right\">\n" +
                                    "<li><a href=\"javascript:void(0)\" class='pagination_a'>&laquo;</a></li>\n" +
                                "</ul>"
                            );
                            for ($i=1;$i<=data.content.total_page;$i++){
                                $("#article_list ul.pagination").append(
                                    "<li><a href=\"javascript:void(0)\" class='pagination_a'>"+$i+"</a></li>\n"
                                );
                            }
                            $("#article_list ul.pagination").append(
                                "<li><a href=\"javascript:void(0)\" class='pagination_a'>&raquo;</a></li>"
                            );
                            $lis = $("#article_list ul.pagination li");
                            if (data.code == 0) {
                                $lis[data.content.current_page].className = 'active';

                                //加载文章列表
                                $list = data.content.list;
                                $list.forEach(function ($item) {
                                    // $item.created_at = tsToDate('Y/m/d H:i:s',''+$item.created_at+'');
                                    $("#article_list #article_ul").append(
                                        "<li class=\"article_li\">\n" +
                                        "<a href=\"/article/article_id/"+$item.id+"\" class=\"article_img col-lg-3\">\n" +
                                        // "<img src=\"https://api.vtrois.com/image/150x150\" alt=\"\">\n" +
                                        "<img src=\"/uploads"+$item.article_img+"\" style=\"width:150px;height:150px\" alt=\"\">\n" +
                                        "</a>\n" +
                                        "<div class=\"article_detail col-lg-9\">\n" +
                                        "<a href=\"/article/article_id/"+$item.id+"\">\n" +
                                        "<p class=\"article_title\">"+$item.article_name+"</p>\n" +
                                        "</a>\n" +
                                        // "<a href=\"#\" class=\"author_head\">\n" +
                                        // "<img src=\"https://api.vtrois.com/image/25x25\" alt=\"\" class=\"author_img\" style=\"border-radius: 50px\">\n" +
                                        // "</a>\n" +
                                        "<span class=\"author\">"+$item.article_author+"</span>\n" +
                                        "<span>"+$item.created_at+"</span>\n" +
                                        "<p class=\"article_content\">\n" +
                                        $item.article_describe +
                                        "</p>\n" +
                                        "</div>\n" +
                                        "</li>"
                                    );
                                });
                            }
                            //文章简介的超过给定范围，去掉后面的文字加上省略号...
                            $(".article_content").each(function (){
                                var maxwidth=150;
                                if($(this).text().length>maxwidth){
                                    var text = $(this).text().substring(0,maxwidth);
                                    $(this).text(text);
                                    $(this).html($(this).html()+'...');
                                }
                            });
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
                });
            }

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
                getArticleList(_page);
            });
        })
    </script>

    @stop
