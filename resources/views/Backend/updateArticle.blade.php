
@extends('layouts.backend')
<link rel="stylesheet" href="/editormd/css/editormd.min.css" />
@section('main_content')
    <!--main content start-->
    <section class="main-content-wrapper">
        <section id="main-content" class="container">
            <div id="loading"></div>
            <div class="row">
                <div class="col-md-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li>
                            <a href="/backend/index">首页</a>
                        </li>
                        <li>文章管理</li>
                        <li class="active">编辑文章</li>
                    </ul>
                    <!--breadcrumbs end -->
                    <h1 class="h1">编辑文章</h1>
                </div>
            </div>
            <div class="alert alert-danger alert-dismissable hidden" id="search_alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <span></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="#" class="form-horizontal" id="photoForm" enctype="multipart/form-data">
                        <div class="form-group col-md-12">
                            <div class="col-md-1 text-center">
                                <label for="upload_pic" class="control-label">首图</label>
                            </div>
                            <div class="col-md-11">
                                <input type="file" class="form-control" name="upload_pic" id="upload_pic" placeholder="图片">
                                <div><img src="" alt="" id="upload_img" style="width: 50px;height: 50px;margin-top: 10px"></div>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal" role="form" id="article_form">
                        <div class="form-group col-md-12">
                            <div class="col-md-1 text-center">
                                <lable for="article_name" class="control-label" >标题:</lable>
                            </div>
                            <div class="col-md-11">
                                <input type="text" class="form-control" id="article_name" name="article_name" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-1 text-center">
                                <lable for="article_author" class="control-label" >作者:</lable>
                            </div>
                            <div class="col-md-11">
                                <input type="text" class="form-control" id="article_author" name="article_author" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-1 text-center">
                                <lable for="keywords" class="control-label" >关键词:</lable>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="keywords1" name="keywords" autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="keywords2" name="keywords" autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="keywords3" name="keywords" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group hidden">
                            <div class="col-sm-11">
                                <input type="text" class="form-control" name="article_img" id="article_img" placeholder="图片">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-1 text-center">
                                <lable for="article_describe" class="control-label" >摘要:</lable>
                            </div>
                            <div class="col-md-11">
                                <textarea type="text" class="form-control" id="article_describe" name="article_describe" placeholder="建议不要超过180个字"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-1 text-center">
                                <label for="category_id" class="control-label">分类:</label>
                            </div>
                            <div class="col-sm-11">
                                <select name="category_id" id="category_id" class="form-control"></select>
                            </div>
                        </div>
                        {{--<div class="form-group col-md-12">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<div id="editor" name="article_content" style="height:600px;"></div>--}}
                            {{--</div>--}}
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-12">
                                <div id="editormd" name="article_content" style="height:600px;">
                                    <textarea style="/**display:none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-sm-2 col-sm-offset-5 text-center">
                                <button type="button" id="save_btn" class="btn btn-primary btn-3d">保存修改</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </section>
    <!--main content end-->
@stop

<!--Load these page level functions-->
@section('js')
    {{----加载markdown----}}
    <script src="/editormd/editormd.min.js"></script>
    <script type="text/javascript">
        let mdEditor;
        $(function() {
            mdEditor = editormd("editormd", {
                width: "100%",
                height: 740,
                path : '/editormd/lib/',
                theme : "dark",
                previewTheme : "dark",
                editorTheme : "pastel-on-dark",
                markdown : "",
                codeFold : true,
                //syncScrolling : false,
                saveHTMLToTextarea : true,    // 保存 HTML 到 Textarea
                searchReplace : true,
                //watch : false,                // 关闭实时预览
                htmlDecode : "style,script,iframe|on*",            // 开启 HTML 标签解析，为了安全性，默认不开启
                //toolbar  : false,             //关闭工具栏
                //previewCodeHighlight : false, // 关闭预览 HTML 的代码块高亮，默认开启
                emoji : true,
                taskList : true,
                tocm            : true,         // Using [TOCM]
                tex : true,                   // 开启科学公式TeX语言支持，默认关闭
                flowChart : true,             // 开启流程图支持，默认关闭
                sequenceDiagram : true,       // 开启时序/序列图支持，默认关闭,
                //dialogLockScreen : false,   // 设置弹出层对话框不锁屏，全局通用，默认为true
                //dialogShowMask : false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为true
                //dialogDraggable : false,    // 设置弹出层对话框不可拖动，全局通用，默认为true
                dialogMaskOpacity : 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为0.1
                //dialogMaskBgColor : "#000", // 设置透明遮罩层的背景颜色，全局通用，默认为#fff
                imageUpload    : true,
                imageFormats   : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL : "/editormd/image/upload",
                onload : function() {
                    // console.log('onload', this);
                    // this.fullscreen();
                    // this.unwatch();
                    // this.watch().fullscreen();

                    // this.setMarkdown($editorContent);
                    // this.width("100%");
                    // this.height(480);
                    this.resize("100%", 640);
                }
            });

            $("#goto-line-btn").bind("click", function(){
                mdEditor.gotoLine(90);
            });

            $("#show-btn").bind('click', function(){
                mdEditor.show();
            });

            $("#hide-btn").bind('click', function(){
                mdEditor.hide();
            });

            $("#get-md-btn").bind('click', function(){
                alert(mdEditor.getMarkdown());
            });

            $("#get-html-btn").bind('click', function() {
                alert(mdEditor.getHTML());
            });

            $("#watch-btn").bind('click', function() {
                mdEditor.watch();
            });

            $("#unwatch-btn").bind('click', function() {
                mdEditor.unwatch();
            });

            $("#preview-btn").bind('click', function() {
                mdEditor.previewing();
            });

            $("#fullscreen-btn").bind('click', function() {
                mdEditor.fullscreen();
            });

            $("#show-toolbar-btn").bind('click', function() {
                mdEditor.showToolbar();
            });

            $("#close-toolbar-btn").bind('click', function() {
                mdEditor.hideToolbar();
            });

            $("#toc-menu-btn").click(function(){
                mdEditor.config({
                    tocDropdown   : true,
                    tocTitle      : "目录 Table of Contents",
                });
            });

            $("#toc-default-btn").click(function() {
                mdEditor.config("tocDropdown", false);
            });
        });
    </script>
    {{----加载markdown END----}}

    <script>
        $(function () {
            //传递过来的文章id
            var id = "{{ $id }}";
            $editorContent = "";

            //获取分类列表
            function getCategoryList(){
                $.ajax({
                    type:'GET',
                    url:'/backend/article/category/all',
                    data:{},
                    dataType:'json',
                    success:function (data) {
                        if (data.code == 0) {
                            var list = data.content;
                            list.forEach(function ($item) {
                                $("#category_id").append(
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
                        if (typeof e.responseJSON.errors !== 'undefined')
                        {
                            for($item in e.responseJSON.errors) {
                                $("#search_alert span").html($item + "格式不符合要求");
                            }
                        }
                    }
                })
            };

            //获取文章内容
            function getArticleDetail(id){
                $.ajax({
                    type:'GET',
                    url:'/backend/article/detail',
                    data:{'article_id':id},
                    dataType:'json',
                    success:function (data) {
                        if (data.code == 0) {
                            $("#article_name").val(data.content.article_name);
                            $("#article_author").val(data.content.article_author);
                            data.content.keywords_one ? $("#keywords1").val(data.content.keywords_one) : $("#keywords1").val('');
                            data.content.keywords_two ? $("#keywords2").val(data.content.keywords_two) : $("#keywords2").val('');
                            data.content.keywords_three ? $("#keywords3").val(data.content.keywords_three) : $("#keywords3").val('');
                            $("#article_img").val(data.content.article_img);
                            $("#upload_img").attr('src','/uploads'+data.content.article_img);
                            $("#article_describe").val(data.content.article_describe);
                            $("#category_id").val(data.content.category_id);
                            mdEditor.setMarkdown(data.content.article_content);
                        } else {
                            $("#search_alert").removeClass("hidden");
                            $("#search_alert span").html("<strong>出错喽~！</strong>");
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
            }

            //加载分类列表
            getCategoryList();
            getArticleDetail(id);

            //保存修改
            $("#save_btn").on("click",function () {
                var article_id = id;
                let article_name = $("#article_name").val();
                let article_author = $("#article_author").val();
                let keywords1 = $("#keywords1").val();
                let keywords2 = $("#keywords2").val();
                let keywords3 = $("#keywords3").val();
                let article_img = $("#article_img").val();
                let article_describe = $("#article_describe").val();
                let category_id = $("#category_id").val();
                let content = mdEditor.getMarkdown();       // 获取 Markdown 源码

                $.ajax({
                    type:'POST',
                    url:'/backend/article/edit',
                    data:{
                        'article_id' : article_id,
                        'article_name' : article_name,
                        'article_author' : article_author,
                        'article_describe' : article_describe,
                        'keywords_one' : keywords1,
                        'keywords_two' : keywords2,
                        'keywords_three' : keywords3,
                        'article_content' : content,
                        'article_img' : article_img,
                        'category_id' : category_id,
                    },
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function (data) {
                        if (data.code == 0) {
                            alert('文章修改成功');
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
            })
        })

        //上传图片
        $("#upload_pic").on("change",function () {
            var upload_pic = new FormData($("#photoForm")[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                type: 'POST',
                url:'/backend/article/upload_pic',
                data: upload_pic,
                processData:false,
                contentType: false,
                cache: false,
                success:function (data) {
                    if (data.code == 0) {
                        $("#article_img").val(data.content);
                        $("#upload_img").attr('src','/uploads'+data.content).css('display','block');
                    }
                },
                error:function (e) {
                    alert('图片上传失败');
                }
            });
        });
    </script>

@stop

