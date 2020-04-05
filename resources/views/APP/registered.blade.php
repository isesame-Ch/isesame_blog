<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="initial-scale=1">
<title>西山小站</title>

<link rel="stylesheet" type="text/css" href="css/login/normalize.css" />
<link rel="stylesheet" type="text/css" href="css/login/demo.css" />
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<!--必要样式-->
<link rel="stylesheet" type="text/css" href="css/login/component.css" />
<style>
	.center-vertical {
		position:relative;
		top:50%;
		transform:translateY(-50%);
	}
	input:-webkit-autofill {
		-webkit-box-shadow: 0 0 0px 1000px #ffffff inset !important;
	}

	.message {
		margin-top: 5px;
		font-size: 16px;
		visibility: hidden;
	}
	.error {
		visibility: visible;
		color: #f44336;
	}
	canvas {
		margin: 0 auto;
		position: absolute;
		top:50%;
		transform:translateY(-50%);
		z-index: -1000;
	}

	@media screen and (max-width: 960px) {
		#title {
			position: relative;
			top: -10px;
			display: inline-block;
			font-size: 20px
		}
		.large-header {
			height: auto;
			overflow: auto;
		}
		.dom {
			padding-top: 280px;
		}

	}

	@media screen and (min-width: 960px) {
		#title {
			position: relative;
			top: -10px;
			display: inline-block;
		}
	}

	#loading {
		width: 100%;
		height: 100%;
		margin: 0 auto;
		z-index: 1000;
		position: absolute;
		background: rgba(0,0,0,1);
		text-align: center;
		display: none;
	}
	img.loading_img{
		position: relative;
		top: 50%;
		margin-top: -150px;
	}
	.loading_letter {
		color: #999;
		position: absolute;
		left: 50%;
		top: 50%;
		margin-top: 40px;
		margin-left: -34.25px;
	}
</style>
	<!--[if IE]>
<script src="js/login/html5.js"></script>
<![endif]-->
</head>
<body>
		<div class="demo-1">
			<div id="loading">
				{{--<img class="loading_img" src="./img/loading.gif" alt="">--}}
				{{--<span class="loading_letter">loading......</span>--}}
			</div>
			<div class="content">
				<div id="large-header" class="large-header">
					<div class="container center-vertical dom">
						<span class="main-title" id="title">创建账户</span>
						<form class="form-horizontal col-sm-12" id="login_form" style="color:#ffffff" onsubmit="return false" action="#" method="post">
							<div class="form-group">
								<label for="username" class="col-sm-1 col-sm-offset-2 control-label" style="text-align: center" ><span style="color: #ff0000">*</span>账号</label>
								<div class="col-sm-6">
									<input type="text" class="form-control"  id="username" name="username" check="required username" title="请输入以字母开头的6~20位字母数字下划线组成的账号" placeholder="请输入您的账号">
									<div class="message">请输入您的账号</div>
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-sm-1 col-sm-offset-2 control-label" style="text-align: center"><span style="color: #ff0000">*</span>密码</label>
								<div class="col-sm-6">
									<input type="password" class="form-control" id="password" check="required length password pwd1" min="6" name="password" title="请输入6~20位字母数字下划线组成的密码" placeholder="请输入您的密码">
									<div class="message">请输入您的密码</div>
								</div>
							</div>
							<div class="form-group">
								<label for="password2" class="col-sm-1 col-sm-offset-2 control-label" style="text-align: center" ><span style="color: #ff0000">*</span>确认密码</label>
								<div class="col-sm-6">
									<input type="password" class="form-control" check="required length password pwd2" min="6" name="password2" title="请重复输入密码" placeholder="请确认您输入的密码">
									<div class="message">请输入您的密码</div>
								</div>
							</div>
							<div class="form-group">
								<label for="nickname" class="col-sm-1 col-sm-offset-2 control-label" style="text-align: center"><span style="color: #ff0000">*</span>昵称</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="nickname" name="nickname" autocomplete="off" title="请输入10位以内的中英文数字下划线" check="required nickname" placeholder="请输入您的昵称">
									<div class="message">请输入您的昵称</div>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-sm-1 col-sm-offset-2 control-label" style="text-align: center"><span style="color: #ff0000">*</span>email</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="email" name="email" title="请输入邮箱" check="required email" placeholder="请输入您的电子邮箱">
									<div class="message">请输入您的电子邮箱</div>
								</div>
							</div>
							<div class="form-group">
								<label for="mobile" class="col-sm-1 col-sm-offset-2 control-label" style="text-align: center"><span style="color: #ff0000">*</span>mobile</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="mobile" name="mobile" title="请输入邮箱" check="required mobile" placeholder="请输入您的手机号">
									<div class="message">请输入您的手机号</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6 col-sm-offset-3">
									<button type="buttom" id="reg_submit" class="btn btn-info btn-lg btn-block">注 册</button>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-4 col-sm-4" style="color:#f44336;text-align: center; font-size: 16px" id="tip">
								</div>
							</div>
						</form>
					</div>
					<canvas id="demo-canvas"></canvas>
				</div>
			</div>
		</div>


		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/jquery.cookie.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/validate-form.js"></script>
		<script>
            $(function () {
                var validateParams = {
                    onChange: function (isValid, $elem, msg) {
                        /*
						   isValid:当前验证是否通过，true：通过；false：不通过；
						   $elem:当前被验证的表单元素，jQuery对象；
						   msg：验证未通过时的错误提示
					   */
                        //如下是验证通过以及未通过时的dom操作
                        if (isValid) {
                            $elem.next().removeClass("error");
                        } else {
                            $elem.focus().next().text(msg).addClass("error");
                        }
                    }
                };

                $("#reg_submit").on("click", function () {

                    var isValid = $("#login_form").ValidateForm(validateParams);
                    if (isValid) {
                        $("#loading").css("display","block");
                        $("#loading").append('<img class="loading_img" src="/img/loading.gif" alt="">');
                        $("#loading").append('<span class="loading_letter">loading......</span>');
                        $("#tip").text('');
                        var username = $('#username').val();
                        var password = $('#password').val();
                        var nickname = $('#nickname').val();
                        var email = $('#email').val();
                        var mobile = $('#mobile').val();
                        $.ajax({
                            type: "POST",
                            url: "/registered",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data:{'username':username,'password':password,'nickname':nickname,'email':email, 'mobile':mobile},
                            dataType:"json",
                            success: function(data) {
                                setTimeout(function () {
                                    $("#loading").empty();
                                    $("#loading").css("display","none");
                                    if (data.code == 0){			//请求成功
                                        $("#tip").html('<a style="color:#fff;" href="'+data.content.url+'">'+',三秒后自动跳转登录页面...</a>');
                                        setTimeout(function () {
                                            window.location = ''+data.content.url+'';
                                        },3000);
									} else {
                                        alert(data.message);
									}
                                },2000);
							},
                            error:function (e) {
                                setTimeout(function () {
                                    $("#loading").empty();
                                    $("#loading").css("display","none");
                                },2000);
                                if(e.responseJSON.message)
                                {
                                    alert(e.responseJSON.message);
                                }
                            }
                        })
                    }
                    return false;
                });
            });


		</script>
		<script src="/js/login/TweenLite.min.js"></script>
		<script src="/js/login/EasePack.min.js"></script>
		<script src="/js/login/rAF.js"></script>
		<script src="/js/login/demo-1.js"></script>

	</body>
</html>