@extends('layouts.layout')
@section('style')
	<style type="text/css">
	body{
		margin:0px;
		padding:0px;
		overflow: hidden;
	}
	#body_container {
		margin: 0;
		padding: 0;
	}
	.home_btn {
		position: absolute;
		top: 10px;
		left: 50px;
		font-size: 50px;
		color: #0f0f0f;
	}
	@media screen and (max-width: 767px) {
		.home_btn {
			position: absolute;
			top: 10px;
			left: 50px;
			font-size: 20px;
			color: #0f0f0f;
		}
	}
	@media screen and (min-width: 768px) and (max-width: 992px) {

	}
	@media screen and (min-width: 993px) and (max-width: 1200px) {

	}
	@media screen and (min-width: 1200px) {

	}
	</style>
	@stop
@section('header')
	@stop
@section('bg_canvas')
	@stop
@section('body_container')
	<div style="text-align:center;">
		<canvas id="linkScreen" width="1366" height="621" style="width: 1366px; height: 621px;">
			很遗憾，您的浏览器不支持HTML5，请使用支持HTML5的浏览器。
		</canvas>
		<a href="/index" class="home_btn"><span class="glyphicon glyphicon-send" aria-hidden="true" title="返回首页"></span></a>
	</div>
	@stop
@section('footer')
	@stop
@section('js')
	<script src="/js/game/require.js"></script>
	<script type="text/javascript" src="/js/game/main.js"></script>
@stop

