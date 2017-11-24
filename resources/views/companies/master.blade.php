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
	<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
	<link rel="stylesheet" type="text/css" href="assets/css/reset.css">
	<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
</head>
<body data-spy="scroll" data-target="#myNav">
	@include('companies.partials.header')
	@yield('header.caption')
	<div class="main">
		@yield('body.content')
		@include('companies.partials.social')
	</div>
	@include('companies.partials.footer')

	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/main.js"></script>
	<script src="assets/js/angular.min.js"></script>
	<script src="assets/js/app.js"></script>
	<script src="assets/js/back-to-top.js"></script>
	<script src="assets/js/animated.js"></script>
	
	@yield('footer.js')
	<script src="assets/js/classie.js"></script>
	
    <script>
    	function init() {
        window.addEventListener('scroll', function(e){
            var distanceY = window.pageYOffset || document.documentElement.scrollTop,
                shrinkOn = 100,
                header = document.querySelector(".header-companies");
            if (distanceY > shrinkOn) {
                classie.add(header,"opacity");
            } else {
                if (classie.has(header,"opacity")) {
                    classie.remove(header,"opacity");
                }
            }
        });
    }
    window.onload = init();
    </script>
</body>
</html>