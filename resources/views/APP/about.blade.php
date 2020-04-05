@extends('layouts.layout')
@section('style')
    <style>
        #user_introduction {
            padding: 0;
            margin:10px 0;
            background-color: rgba(255,255,255,0.8);
            height: 760px;
        }
        #user_introduction_head {
            margin: 15px auto;
            width: 100px;
            height: 100px;
        }
        .user_introduction_img {
            border-radius: 50px;
        }
        #user_introduction_detail {
            margin-top: 10px;
            background-color: #fff;
        }
        #user_introduction_ul {
            list-style: none;
            padding: 0;
            height: 70px;
            margin-bottom: 0;
        }
        #user_introduction_ul li {
            float: left;
            text-align: center;
            vertical-align: middle;
            width: 33%;
            height: 70px;
            font-size: 12px;
            padding: 0 5px;
        }
        #user_introduction_ul li:first-child,#user_introduction_ul li:nth-child(2) {
            border-right: 1px #eee solid;
        }
        #user_introduction_ul li span {
            font-size: 22px;
            display: inline-block;
            width: 100%;
            border-bottom: 2px #000 solid;
            margin-bottom: 10px;
        }
        #user_introduction_text {
            margin-top: 20px;
            text-align: center;
            font-size: 22px;
        }
        #user_introduction_content {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
    </style>
@stop
@section('user_sidebar')
    <div class="sidebar col-lg-12" id="user_introduction">
        <div id="user_introduction_head">
            <img src="/img/introduction_head_pic.png" class="user_introduction_img" alt="" style="width: 100px;height: 100px;">
        </div>
        <div id="user_introduction_detail">
            <ul id="user_introduction_ul">
                <li class="col-lg-4">
                    <span>20</span>
                    会员数
                </li>
                <li class="col-lg-4">
                    <span>5</span>
                    文章数
                </li>
                <li class="col-lg-4">
                    <span>3</span>
                    标签总数
                </li>
            </ul>
        </div>
        <div class="col-lg-6 col-lg-offset-3" id="user_introduction_text">
            <span id="user_introduction_title">我的简介</span>
            <p id="user_introduction_content">
                Hello!!  我叫ISESAME,现从事互联网工作，目前就职于 ~~~（我就不说XD）。我的工作方向是PHP后台开发方面，不过也一直在学习前端开发和Linux服务器，比较喜欢的就是研究新技术，得跟上时代的脚步，不停的学习
            </p>
        </div>
    </div>
@stop

@section('recommend_sidebar')
@stop