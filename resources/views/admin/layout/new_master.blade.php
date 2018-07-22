    <!DOCTYPE html>
<html ng-app="my-app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Dashboard</title>
    <base href="{{asset('')}}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="assets/template/adminlte/bower_components/Ionicons/css/ionicons.min.css">
      <!-- DataTables -->
     <link rel="stylesheet" href="assets/template/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/template/adminlte/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/template/adminlte/dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="assets/template/adminlte/bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="assets/template/adminlte/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="assets/template/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="assets/template/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="assets/template/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- Angular UI Select -->
    <link rel="stylesheet" href="assets/css/ui-select/select2.css">
    <link rel="stylesheet" href="assets/css/ui-select/selectize.bootstrap3.css">
    <link rel="stylesheet" href="assets/css/ui-select/select.css">

    <!-- My custom -->
    <link rel="stylesheet" href="assets/css/new_admin.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- HEADER -->
        @include('admin.layout.new_header')

        <!-- Left side column. contains the logo and sidebar -->
        @include('admin.layout.new_sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @yield('primary-title')
                    <small>@yield('secondary-title')</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="admin/statistics#">
                            <i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">@yield('primary-title')</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content" id="king-content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>

        <!-- /.content-wrapper -->
        @include('admin.layout.new_footer')

        <!-- Control Sidebar -->
        @include('admin.layout.new_rightside')
        <!-- /.control-sidebar -->


        <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="assets/js/jquery.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="assets/template/adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="assets/template/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/template/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="assets/template/adminlte/bower_components/raphael/raphael.min.js"></script>
    <script src="assets/template/adminlte/bower_components/morris.js/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="assets/template/adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="assets/template/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/template/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="assets/template/adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="assets/template/adminlte/bower_components/moment/min/moment.min.js"></script>
    <script src="assets/template/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="assets/template/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="assets/template/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="assets/template/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="assets/template/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/template/adminlte/dist/js/adminlte.min.js"></script>
    <!-- Select2 -->
    <script src="assets/template/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>

    <!-- My Custom -->
    <script src="assets/js/new_admin.js"></script>


        <!-- AngularJS   -->
    <script src="assets/js/angular.min.js"></script>
    <script src="assets/angularjs/app.js"></script>
    <script src="assets/angularjs/module/dirPagination.js"></script>
    <script src="assets/js/select.js"></script>
    <script src="assets/js/toaster.js"></script>
    <script src="assets/js/lodash.min.js"></script>
    <script src="assets/angularjs/controller/LoginController.js"></script>
    <script src="assets/angularjs/controller/DashBoardController.js"></script>
    @yield('script')
</body>
</html>
