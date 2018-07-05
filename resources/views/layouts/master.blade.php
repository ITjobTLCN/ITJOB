<!DOCTYPE html>
<html lang="en" ng-app="my-app">
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<base href="{{asset('')}}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="author" content="">
	<meta name="description" content="ITJOB For You"/>
	<link rel="icon" type="image/png" href="favicon.png"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/reset.css">
	<link rel="stylesheet" type="text/css" href="assets/css/emp.css">
	<link rel="stylesheet/less" type="text/css" href="assets/less/styles.less">
	<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/ui-select/select2.css">
    <link rel="stylesheet" href="assets/css/ui-select/selectize.bootstrap3.css">
	<link rel="stylesheet" href="assets/css/ui-select/select.css">
	@yield('header.css')
	<script type="text/javascript" src="assets/plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	@yield('header.js')
</head>
<body>
	@include('partials.header')
	@yield('header.caption')
	<div class="main">
		@yield('body.content')
	</div>
	@include('partials.social')
	@include('partials.footer')
	@include('partials.js')
	@yield('footer.js')
</body>
</html>