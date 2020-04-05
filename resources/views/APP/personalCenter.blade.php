@extends('layouts.layout')
@section('style')
    <style>
        #user_info_form {
            line-height: 45px;color:#999999;
        }
        #upload_pic {
            height: 40px;
        }
    </style>
@stop
@section('body_container')
    <div class="col-lg-8">
        <form class="col-lg-12" style="line-height: 45px;color: #999999;" id="user_head_form">
            <div class="form-group">
                <div style="width: 80px;margin-left: -40px;position: relative;left: 50%;">
                    @if (strpos(Auth::user()->userInfo->head_pic,'http') === false && strpos(Auth::user()->userInfo->head_pic,'https') === false)
                        <img src="/uploads{{ Auth::user()->userInfo->head_pic }}" id="display_head_pic" alt="" style="width: 80px;height: 80px;margin-bottom: 10px">
                    @else
                        <img src="{{ Auth::user()->userInfo->head_pic }}" id="display_head_pic" alt="" style="width: 80px;height: 80px;border-radius: 50px;margin-bottom:10px;margin-left: 50px;">
                    @endif
                </div>
                <lable for="upload_pic">头像:</lable>
                <input type="file" class="form-control" id="upload_pic" name="upload_pic" placeholder="图片">
            </div>
        </form>
        <form class="col-lg-12"  style="" id="user_info_form">
            <div class="form-group hidden">
                <input type="text" class="form-control" name="head_pic" id="head_pic" placeholder="图片">
            </div>
            <div class="form-group">
                <lable for="nickname">昵称:</lable>
                <input type="text" class="form-control" id="nickname" name="nickname" autocomplete="off" value="{{ Auth::user()->userInfo->nickname }}">
            </div>
            <div class="form-group">
                <lable for="email">邮箱:</lable>
                <input type="email" class="form-control" id="email" name="email"autocomplete="off" value="{{ Auth::user()->userInfo->email }}">
            </div>
            <div class="form-group">
                <lable for="mobile">手机:</lable>
                <input type="text" class="form-control" id="mobile" name="mobile" autocomplete="off" value="{{ Auth::user()->userInfo->mobile }}">
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-warning btn-trans form-control" id="edit_btn" style="margin-top: 5px">变更</button>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        //上传图片
        $("#upload_pic").on("change",function () {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                type: 'POST',
                url:'/user/upload_pic',
                data: new FormData($("#user_head_form")[0]),
                processData:false,
                contentType: false,
                cache: false,
                success:function (data) {
                    if (data.code == 0) {
                        $("#head_pic").val(data.content);
                        $("#display_head_pic").attr('src','/uploads'+data.content);
                    } else {
                        console.log(data.message);
                        alert('图片上传失败');
                    }
                },
                error:function (e) {
                    console.log(e);
                    alert('图片上传失败');
                }
            });
        });

        // 编辑用户信息
        $("#edit_btn").on("click", function () {
            $data = $("#user_info_form").serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                type: 'POST',
                url:'/user/edit',
                data: $data,
                success:function (data) {
                    if (data.code == 0) {
                        alert('更新成功');
                        window.location = "";
                    } else {
                        console.log(data.message);
                        alert('更新失败:'+data.message);
                    }
                },
                error:function (e) {
                    console.log(e);
                    alert('更新失败');
                }
            });
        })
    </script>

@stop