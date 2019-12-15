@extends('layouts.layout')
@section('style')
    <style>
        /*
        内容模块
         */
        #content {
            margin:10px 0;
        }
        h1#article_title {
            font-size: 26px;
            line-height: 39px;
        }
        .tag_ul {
            display: inline-block;
            padding: 0;
            font-size: 12px;
            color: #fefefe;
            height: 25px;
            clear: both;
        }
        .tag_li {
            margin-bottom: 5px;
            margin-right: 5px;
            padding: 3px 5px;
            list-style: none;
            float: left;
            background-color: #333;
        }
        .article_info {
            font-size: 12px;
            font-weight: 600;
            height: 25px;
            line-height: 25px;
        }
        .article_info span {
            margin-right: 10px;
            padding: 3px 5px;
        }
        #article_time i {
            margin-right: 5px;
        }
        #article_content {
            border-top: 1px #ccc solid;
            margin-top: 60px;
            font-size: 18px;
            line-height: 36px;
        }

        @media screen and (max-width: 767px) {
            .tag_ul {
                display: none;
            }
            h1#article_title {
                overflow: hidden;
                text-overflow:ellipsis;
                white-space: nowrap;
            }
        }
    </style>
    @stop
@section('body_container')
        <div class="col-lg-8" id="content" style="background-color:#eee;">
            <h1 id="article_title">文章标题</h1>
            <ul class="tag_ul col-sm-5">
                <li class="tag_li" id="keywords1">item</li>
                <li class="tag_li" id="keywords2">item</li>
                <li class="tag_li" id="keywords3">item</li>
            </ul>
            <div class="col-sm-7 article_info">
                <span class="author pull-right" id="article_author">作者：佚名</span>
                <span class="pull-right" id="article_time"><i class="glyphicon glyphicon-time"></i>2018-7-26 0:41:00</span>
            </div>

            <div id="article_content">
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px"></h1>
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <div style="background-color: #bbb;height: 300px;"></div>
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px"></h1>
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <div style="background-color: #bbb;height: 300px;"></div>
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px"></h1>
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <div style="background-color: #bbb;height: 300px;"></div>

            </div>
        </div>
    @stop

@section('js')
    <script>
        $(function () {
            var id = "<?php echo $id?>";

            function getArticle(id) {
                $.ajax({
                    type:'GET',
                    url:'/article/detail',
                    data:{'article_id':id},
                    dataType:'json',
                    success:function (data) {
                        data.content.created_time = tsToDate('Y-m-d H:i:s','' + data.content.created_time + '');
                        $('#article_title').html(data.content.article_name);
                        $('#article_content').html(data.content.article_content);
                        $('#article_author').html(data.content.article_author);
                        $('#article_time').text(data.content.created_at);
                        if (data.content.keywords_one) {
                            $('#keywords1').text(data.content.keywords_one);
                        } else {
                            $('#keywords1').remove();
                        }
                        if (data.content.keywords_two) {
                            $('#keywords2').text(data.content.keywords_two);
                        } else {
                            $('#keywords2').remove();
                        }
                        if (data.content.keywords_three) {
                            $('#keywords3').text(data.content.keywords_three);
                        } else {
                            $('#keywords3').remove();
                        }
                    },
                    error:function (e) {
                        console.log('555~出错喽~！')
                    }
                })
            };

            getArticle(id);
        })
    </script>

    @stop
