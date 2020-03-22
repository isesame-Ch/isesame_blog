<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>西山小站</title>

<link rel="stylesheet" type="text/css" href="css/login/normalize.css" />
<link rel="stylesheet" type="text/css" href="css/login/demo.css" />
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<!--必要样式-->
<link rel="stylesheet" type="text/css" href="css/login/component.css" />
<script src="https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.js"></script>
<style>
	.center-vertical {
		position:relative;
		top:50%;
		transform:translateY(-50%);
	}
	input:-webkit-autofill {
		-webkit-box-shadow: 0 0 0px 1000px #ffffff inset !important;
	}
	#registered {
		color:#5a758c;
		padding: 5px;
	}
	#registered:hover {
		color:#fff;
		text-decoration: none;
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
					<div class="container center-vertical">
						<span class="main-title" id="title">Welcome To isesame Pub</span>
						<form class="form-horizontal col-sm-12" id="login_form" style="color:#ffffff" onsubmit="return false" action="#" method="post">
							<div class="form-group">
								<label for="username" class="col-sm-1 col-sm-offset-2 control-label">账号</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="username" name="username" check="required username" placeholder="请输入您的账号">
									<div class="message">请输入您的账号</div>
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-sm-1 col-sm-offset-2 control-label">密码</label>
								<div class="col-sm-6">
									<input type="password" class="form-control" id="password" check="required length password" min="6" name="password" placeholder="请输入您的密码">
									<div class="message">请输入您的密码</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6 col-sm-offset-3">
                                    <input type="button" id="login_submit" class="btn btn-info btn-lg btn-block" value="登录" >
								</div>
								<div class="col-sm-4 col-sm-offset-4" style="margin-top: 20px;text-align: center">
									<a href="/registered" target="_blank" id="registered">还没有账号，赶快注册吧~</a>
								</div>
								<div class="col-sm-4 col-sm-offset-4" style="margin-top: 20px;text-align: center">
									<a target="_blank" onclick="toQQLogin()"><img width="30px" title="QQ登录" src="/img/login/Connect_logo_1.png" alt=""></a>
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

		<script>
            function toQQLogin()
            {
                //以下为按钮点击事件的逻辑。注意这里要重新打开窗口
                //否则后面跳转到QQ登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
                var A = window.open("oauth/qq/index","TencentLogin", "width=450,height=320,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
            }
		</script>
		<script src="/js/jquery-3.3.1.min.js"></script>
		<script src="/js/jquery.cookie.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/validate-form.js"></script>
		<script>
            $(function () {
                $("#login_submit").on("click", login);
                $(document).keyup(function(event){
                    if(event.keyCode ==13){
                        login();
                    }
                });
            });

            function login() {
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

                var isValid = $("#login_form").ValidateForm(validateParams);
                if (isValid) {
                    $("#loading").css("display","block");
                    $("#loading").append('<img class="loading_img" src="/img/loading.gif" alt="">');
                    $("#loading").append('<span class="loading_letter">loading......</span>');
                    $("#tip").text(' ');
                    var username = $('#username').val();
                    var password = $('#password').val();
                    $.ajax({
                        type: "POST",
                        url: "/login",
                        data:{'username':username,'password':password},
                        dataType:"json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.code == 0) {
                                setTimeout(function () {
                                    $("#loading").empty();
                                    $("#loading").css("display","none");
                                    //设置三小时过期
                                    var cookie_expires=new Date();
                                    cookie_expires.setTime(cookie_expires.getTime()+3*3600*1000);
                                    // $.cookie('cache_key',data.content.cacheKey,{ expires: cookie_expires });
                                    // $.cookie('access_token',data.content.token,{ expires: cookie_expires });
                                    $.cookie('user',JSON.stringify(data.content.user),{ expires: cookie_expires });
                                    window.location = ''+data.content.url+'';
                                },3000);
                            } else {
                                setTimeout(function () {
                                    $("#loading").empty();
                                    $("#loading").css("display","none");
                                },3000);
                                alert(data.message);
                            }
                        },
                        error:function (e) {
                            setTimeout(function () {
                                $("#loading").empty();
                                $("#loading").css("display","none");
                            },3000);
                            if(e.responseJSON.message)
                            {
                                alert(e.responseJSON.message);
                            }
                        }
                    })
                }
                return false;
            }

		</script>
		<script src="/js/login/TweenLite.min.js"></script>
		<script src="/js/login/EasePack.min.js"></script>
		<script src="/js/login/rAF.js"></script>
		<script src="/js/login/demo-1.js"></script>

	</body>
</html>