@extends('layouts.master')
@section('title')
Login | ITJob
@stop
@section('body.content')
<div class="container">
<div class="wrapper">
	<div class="form-login well well-lg">
		<div class="row">
			<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="login_header">
				<div class="title">
					<h1 class="text-center">Đăng nhập</h1>
					<h4 class="text-center">Đăng nhập hoặc đăng ký thành viên nhanh bằng tài khoản</h4>
				</div>
				<div class="social text-center">

					<button class="btn btn-primary"><i class="fa fa-fw fa-facebook"></i> Facebook</button>
					<button class="btn btn-danger"><i class="fa fa-fw fa-google"></i> Google</button>
				</div>
			</div>
			<hr>
			<div class="login_content text-center">
				<h4>Đăng nhập bằng tài khoản ITJob</h4>
				@if($errors->has('errorLogin'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{$errors->first('errorLogin')}}
				</div>
				@endif
				<form action="{{route('login')}}" method="POST" role="form" name="frmLogin">
					<div class="form-group">
						<input type="email" class="form-control" name="email" id="" placeholder="Email" ng-model="email" required>
						<div id="error">
							<span style="color:red" ng-cloak ng-show="(frmLogin.email.$dirty && frmLogin.email.$invalid)">
								<span ng-show="frmLogin.email.$error.required">Please enter a email.</span>
								<span ng-show="frmLogin.email.$error.email">Please enter a valid email address.</span>
							</span>
						</div>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" id="" placeholder="Password" ng-model="password" ng-required="true" minlength="6" max="30">
						<div id="error">
							<span style="color:red" ng-cloak ng-show="(frmLogin.password.$dirty && frmLogin.password.$invalid)">
								<span ng-show="frmLogin.password.$error.minlength">Your password must be at least 6 characters long.</span>
								<span ng-show="frmLogin.password.$error.required">Please enter a password.</span>
								<span ng-show="frmLogin.password.$error.max">Your password must not greater than 30 characters long.</span>
							</span>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-login" ng-disabled="frmLogin.$invalid">Đăng nhập</button>
					{{ csrf_field() }}
				</form>
			</div>
			<hr>
			<div class="register text-center">
				<h4>Bạn chưa có tài khoản? <a href="{{route('register')}}" style="color: #337ab7">Đăng ký ngay</a></h4>
			</div>
		</div>
		<div class="col-md-3"></div>
		</div>
	</div>
</div>
</div>
@stop
@section('footer.js')
<script src="assets/controller/UsersController.js"></script>
<script>
</script>
@stop