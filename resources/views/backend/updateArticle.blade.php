
@extends('layouts.backend')
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
                        <div class="form-group col-md-12">
                            <div class="col-md-12">
                                <div id="editor" name="article_content" style="height:600px;"></div>
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
    <script type="text/javascript" charset="utf-8" src="/js/editor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/editor/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/js/editor/lang/zh-cn/zh-cn.js"></script>
    {{--END语言加载--}}
    {{-- 获取编辑器内容的方法 --}}
    <script type="text/javascript">

        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('editor',{
            toolbars: [
                [
                    'undo', //撤销
                    'redo', //重做
                    'bold', //加粗
                    'indent', //首行缩进
                    'italic', //斜体
                    'underline', //下划线
                    'strikethrough', //删除线
                    'subscript', //下标
                    'fontborder', //字符边框
                    'superscript', //上标
                    'formatmatch', //格式刷
                    'source', //源代码
                    'pasteplain', //纯文本粘贴模式
                    'preview', //预览
                    'horizontal', //分隔线
                    'removeformat', //清除格式
                    'time', //时间
                    'date', //日期
                    'cleardoc', //清空文档
                    'insertparagraphbeforetable', //"表格前插入行"
                    'insertcode', //代码语言
                    'fontfamily', //字体
                    'fontsize', //字号
                    'paragraph', //段落格式
                    'simpleupload', //单图上传
                    'insertimage', //多图上传
                    'link', //超链接
                    'emotion', //表情
                    'spechars', //特殊字符
                    'searchreplace', //查询替换
                    'map', //Baidu地图
                    'insertvideo', //视频
                    'help', //帮助
                    'justifyleft', //居左对齐
                    'justifyright', //居右对齐
                    'justifycenter', //居中对齐
                    'justifyjustify', //两端对齐
                    'forecolor', //字体颜色
                    'backcolor', //背景色
                    'insertorderedlist', //有序列表
                    'insertunorderedlist', //无序列表
                    'fullscreen', //全屏
                    'directionalityltr', //从左向右输入
                    'directionalityrtl', //从右向左输入
                    'rowspacingtop', //段前距
                    'rowspacingbottom', //段后距
                    'pagebreak', //分页
                    'attachment', //附件
                    'imagecenter', //居中
                    'wordimage', //图片转存
                    'lineheight', //行间距
                    'edittip ', //编辑提示
                    'customstyle', //自定义标题
                    'autotypeset', //自动排版
                    'touppercase', //字母大写
                    'tolowercase', //字母小写
                    'background', //背景
                    'template', //模板
                    'scrawl', //涂鸦
                    'music', //音乐
                    'inserttable', //插入表格
                    'edittable', //表格属性
                    'edittd', //单元格属性
                    'insertrow', //前插入行
                    'insertcol', //前插入列
                    'mergeright', //右合并单元格
                    'mergedown', //下合并单元格
                    'deleterow', //删除行
                    'deletecol', //删除列
                    'splittorows', //拆分成行
                    'splittocols', //拆分成列
                    'splittocells', //完全拆分单元格
                    'deletecaption', //删除表格标题
                    'inserttitle', //插入标题
                    'mergecells', //合并多个单元格
                    'deletetable', //删除表格
                    'drafts', // 从草稿箱加载
                    'charts', // 图表
                ]
            ],
            autoHeightEnabled: true,
            autoFloatEnabled: true,
            //启用自动保存
            enableAutoSave: true,
            //自动保存间隔时间， 单位ms
            saveInterval: 1000*60*5,
            maximumWords:100000
        });
        function getContent() {
            var arr = [];
            arr.push(UE.getEditor('editor').getContent());
            return arr;
        }
    </script>
    {{-- END!! --}}

    <script>
        $(function () {
            //传递过来的文章id
            var id = "<?php echo $id?>";

            //获取分类列表
            function getCategoryList(){
                $.ajax({
                    type:'GET',
                    url:'/backend/article/categorylist',
                    data:{'cacheKey':$cacheKey,'token':$token},
                    dataType:'json',
                    success:function (data) {
                        var list = data.content.list;
                        list.forEach(function ($item) {
                            $("#category_id").append(
                                "<option value='"+$item.id+"'>"+$item.name+"</option>"
                            )
                        });
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
                    data:{'article_id':id,'cacheKey':$cacheKey,'token':$token},
                    dataType:'json',
                    success:function (data) {
                        $("#article_name").val(data.content.article_name);
                        $("#article_author").val(data.content.article_author);
                        $("#keywords1").val(data.content.keywords1);
                        $("#keywords2").val(data.content.keywords2);
                        $("#keywords3").val(data.content.keywords3);
                        $("#article_img").val(data.content.article_img);
                        $("#upload_img").attr('src','/uploads'+data.content.article_img);
                        $("#article_describe").val(data.content.article_describe);
                        $("#category_id").val(data.content.category_id);
                        UE.getEditor('editor').setContent(''+data.content.article_content+'', false);
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

            //等编辑器加载好后再操作，否则有时候会报错
            ue.ready(function(){

                //加载文章内容
                getArticleDetail(id);

                //保存修改
                $("#save_btn").on("click",function () {
                    var article_id = id;
                    var article_name = $("#article_name").val();
                    var article_author = $("#article_author").val();
                    var keywords1 = $("#keywords1").val();
                    var keywords2 = $("#keywords2").val();
                    var keywords3 = $("#keywords3").val();
                    var keywords = {'keywords1':keywords1,'keywords2':keywords2,'keywords3':keywords3};
                    keywords = JSON.stringify(keywords);
                    var article_img = $("#article_img").val();
                    var article_describe = $("#article_describe").val();
                    var category_id = $("#category_id").val();
                    var content = getContent()[0];

                    $.ajax({
                        type:'POST',
                        url:'/backend/article/edit',
                        data:{
                            'article_id' : article_id,
                            'article_name' : article_name,
                            'article_author' : article_author,
                            'keywords' : keywords,
                            'article_img' : article_img,
                            'article_describe' : article_describe,
                            'category_id' : category_id,
                            'article_content' : content,
                            'cacheKey':$cacheKey,
                            'token':$token
                        },
                        dataType:'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function (data) {
                            alert('文章修改成功');
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

            //上传图片
            $("#upload_pic").on("change",function () {
                var upload_pic = new FormData($("#photoForm")[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'cacheKey':$cacheKey,
                        'token':$token
                    },
                    type: 'POST',
                    url:'/backend/article/upload_pic',
                    data: upload_pic,
                    processData:false,
                    contentType: false,
                    cache: false,
                    success:function (data) {
                        if (data.code == 0)
                        {
                            $("#article_img").val(data.content);
                            $("#upload_img").attr('src','/uploads'+data.content);
                        }
                    },
                    error:function (e) {
                        alert('图片上传失败');
                    }
                });
            });
        })
    </script>

@stop

