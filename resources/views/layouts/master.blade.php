<!DOCTYPE html>
<html lang="en" ng-app="my-app">
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<base href="{{asset('')}}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="author" content="">
	<meta name="description" content="La casa free real state fully responsive html5/css3 home page website template"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/reset.css">
	<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
	<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
</head>
<body>
	@include('partials.header')
	@yield('header.caption')
	<div class="main">
		@yield('body.content')
		@include('partials.social')
	</div>
	@include('partials.footer')
	@include('partials.js')
	@yield('footer.js')
</body>
</html>