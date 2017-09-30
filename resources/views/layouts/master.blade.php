<!DOCTYPE html>
<html lang="en" ng-app="my-app">
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<base href="{{asset('')}}">
	<meta name="author" content="">
	<meta name="description" content="La casa free real state fully responsive html5/css3 home page website template"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/reset.css">
	<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	<style>
		.affix {
	      top:0;
	      width: 100%;
	      z-index: 9999 !important;
	  }
	  [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
      	display: none !important;
    }
	</style>
</head>
<body>
	@include('partials.header')
	@yield('header.caption')
	<div class="main">
		@yield('body.content')
	</div>
	@include('partials.footer')
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/main.js"></script>
	<script src="assets/js/angular.min.js"></script>
	<script src="assets/js/app.js"></script>
	@yield('footer.js')
</body>
</html>