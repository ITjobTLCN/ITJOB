<!DOCTYPE html>
<html lang="en" ng-app="my-app">
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="author" content="">
	<meta name="description" content="La casa free real state fully responsive html5/css3 home page website template"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
	<link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap-theme.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/reset.css')}}">
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
<body data-spy="scroll" data-target="#myNav">
	@include('companies.partials.header')
	@yield('header.caption')
	<div class="main">
		@yield('body.content')
		@include('companies.partials.social')
	</div>
	@include('companies.partials.footer')

	<script type="text/javascript" src="{{asset('assets/js/jquery.js')}}"></script>
	<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/main.js')}}"></script>
	<script src="{{asset('assets/js/angular.min.js')}}"></script>
	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('assets/js/back-to-top.js')}}"></script>
	<script src="{{asset('assets/js/animated.js')}}"></script>
	
	@yield('footer.js')
	<script src="{{asset('assets/js/classie.js')}}"></script>
	
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