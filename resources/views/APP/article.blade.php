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

            <div id="article_content" style="padding: 5px;">
                <div id="article_content_detail" class="hidden" style="background-color: #fff0" >
                    <textarea></textarea>
                </div>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px"></h1>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <div class="pre_div" style="background-color: #bbb;height: 300px;"></div>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px"></h1>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <div class="pre_div" style="background-color: #bbb;height: 300px;"></div>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px"></h1>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <h1 class="pre_div" style="background-color: #bbb;height: 24px;line-height: 24px;"></h1>
                <div class="pre_div" style="background-color: #bbb;height: 300px;"></div>

            </div>
        </div>
    @stop

@section('js')
    <link rel="stylesheet" href="/editormd/css/editormd.css" />
    <script src="/editormd/jquery.min.js"></script>
    <script src="/editormd/lib/marked.min.js"></script>
    <script src="/editormd/lib/prettify.min.js"></script>
    <script src="/editormd/lib/raphael.min.js"></script>
    <script src="/editormd/lib/underscore.min.js"></script>
    <script src="/editormd/lib/sequence-diagram.min.js"></script>
    <script src="/editormd/lib/flowchart.min.js"></script>
    <script src="/editormd/editormd.min.js"></script>
    <script>
        function decodeMarkedown (markdown) {
            content_md = editormd.markdownToHTML("article_content_detail", {
                markdown:markdown,
                htmlDecode      : "style,script",  // you can filter tags decode
                emoji           : true,
                taskList        : true,
                tex             : true,  // 默认不解析
                flowChart       : false,  // 默认不解析
                sequenceDiagram : false,  // 默认不解析
            });
        }
    </script>
    <script>
        $(function () {
            var id = "{{ $id }}";

            function getArticle(id) {
                $.ajax({
                    type:'GET',
                    url:'/article/detail',
                    data:{'article_id':id},
                    dataType:'json',
                    success:function (data) {
                        if (data.code == 0) {
                            $('.pre_div').remove();
                            $("#article_content_detail").removeClass("hidden");
                            $('#article_title').html(data.content.article_name);
                            decodeMarkedown(data.content.article_content);
                            // $('#article_content').html(data.content.article_content);
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
                        } else {
                            alert('555~出错喽~！')
                        }
                    },
                    error:function (e) {
                        alert('555~出错喽~！')
                    }
                })
            };

            getArticle(id);
        })
    </script>

    @stop
