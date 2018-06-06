<!DOCTYPE html>
<html lang="en" ng-app="my-app">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="{{asset('')}}">
    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- my style -->
     <link href="assets/css/admin.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/sb-admin.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="assets/fonts/Oswald/oswald.css">



</head>

<body>

    <div id="wrapper">

        @include('admin.layout.header')
        @include('admin.layout.sidebar')
        <div id="page-wrapper">
            @yield('content')
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- include modal login -->
    @include('partials.modal-login')

    <!-- jQuery -->
    <script src="assets/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/js/angular.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    
    <!-- AngularJS   -->
    <script src="assets/angularjs/module/dirPagination.js"></script>
    <script src="assets/angularjs/app.js"></script>
    <script src="assets/js/lodash.min.js"></script>
    <script src="assets/js/select.js"></script>
    <script src="assets/angularjs/controller/UsersController.js"></script>
    <script src="assets/angularjs/controller/EmpController.js"></script>
    <script src="assets/angularjs/controller/LoginController.js"></script>
    <script src="assets/angularjs/controller/DashBoardController.js"></script>

    <!-- modules angularjs -->
    <!-- show modal login if dont login with Admin -->
    @if(!empty(Session::get('error_code')) && Session::get('error_code') == 1)
        <script>$('#loginModal').modal('show');</script>
    @endif

    @yield('script')

</body>

</html>
