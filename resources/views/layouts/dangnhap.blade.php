@extends('layouts.master')
@section('title')
Login | ITJob
@stop
@section('body.content')
<div class="container">
	<div class="form-login well well-lg">
		<div class="row">
			<div class="col-md-3 hidden-xs"></div>
		<div class="col-md-6 col-xs-12">
			<div class="login_header">
				<div class="title">
					<h1 class="text-center">Đăng nhập</h1>
					<h4 class="text-center">Đăng nhập hoặc đăng ký thành viên nhanh bằng tài khoản</h4>
				</div>
				<div class="social text-center">

					<a class="btn btn-primary" href="{{route('loginProvider','facebook')}}"><i class="fa fa-fw fa-facebook"></i>Sign in with Facebook</a>
					<a class="btn btn-danger" href="{{route('loginProvider','google')}}"><i class="fa fa-fw fa-google"></i>Sign in with Google</a>
				</div>
			</div>
			<hr>
			<div class="login_content text-center">
				<h4>Đăng nhập bằng tài khoản ITJob</h4>
				<p style="color: red;display: none;" class="error errorLogin"></p>
				<form role="form" name="frmLogin" id="frmLogin">
					<div class="form-group">
						<input type="email" class="form-control" name="email" id="email" placeholder="Email" >
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" id="password" placeholder="Password">
					</div>
					<button type="submit" class="btn btn-primary btn-login">Đăng nhập</button>
					{{ csrf_field() }}
				</form>
			</div>
			<hr>
			<div class="register text-center">
				<h4>Bạn chưa có tài khoản? <a href="#" data-toggle="modal" data-target="#modalRegister" style="color: #337ab7">Đăng ký ngay</a></h4>
				
			</div>
		</div>
		<div class="col-md-3 hidden-xs"></div>
		</div>
	</div>
</div>
@stop
@section('footer.js')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
<script src="assets/controller/UsersController.js"></script>

<script src="assets/js/validate-form.js"></script>

@stop