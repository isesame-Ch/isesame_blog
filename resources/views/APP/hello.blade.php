<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>西山小站</title>
</head>
<body>
<form onsubmit="return false" action="##" method="post">
    <input type="text" value="111">
    <input type="button" value="登录" onclick="login()">
</form>

<script src="js/jquery-3.3.1.min.js"></script>

<script type="text/javascript">
    function login() {
        $.ajax({
            //几个参数需要注意一下
            type: "POST",//方法类型
            dataType: "json",//预期服务器返回的数据类型
            url: "/hello" ,//url
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                console.log(result);//打印服务端返回的数据(调试用)
                if (result.resultCode == 200) {
                    alert("SUCCESS");
                }
            },
            error : function() {
                alert("异常！");
            }
        });
    }
</script>
</body>