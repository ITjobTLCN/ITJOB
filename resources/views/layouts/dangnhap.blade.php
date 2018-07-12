@extends('layouts.master')
@section('title')
Login | ITJob
@stop
@section('header.css')
<link rel="stylesheet" type="text/css" href="assets/less/card.less">
@stop
@section('body.content')
<div class="container">
	<div class="form-card">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card-group">
					<div class="card col-md-6 text-white bg-default">
						<div class="card-body">
							<h1>Login</h1>
							<p class="text-muted mb-3">Login to your account</p>
							@if($errors->has('errorLogin'))
							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								{{$errors->first('errorLogin')}}
							</div>
							@endif
							<form role="form" name="frmLogin" method="post" action="{{route('login')}}">
								<div class="input-group mb-3">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input type="email" class="form-control" name="email" 
										placeholder="Email" value="{{old('email')}}">
									@if($errors->has('email'))
									<p style="color: red">{{$errors->first('email')}}</p>
									@endif
								</div>
								<div class="input-group mb-4">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
									<input type="password" class="form-control" name="password" placeholder="Password">
									@if($errors->has('password'))
									<p style="color: red">{{$errors->first('password')}}</p>
									@endif
								</div>
								{{ csrf_field() }}
								<button type="submit" class="btn btn-success btn-login br-0" style="width: 100%">Login</button>
							</form>
							<hr>
							<div class="text-center" style="margin: 10px 0"><span>Or</span></div>
							 <div class="social text-center mb-3 row">

							 	<div class="col-md-6">
							 		<a class="btn btn-facebook" href="{{route('loginProvider','facebook')}}" style="width: 100%"><span>Facebook</span></a>
							 	</div>
							 	<div class="col-md-6">
							 		<a class="btn btn-google" href="{{route('loginProvider','google')}}" style="width: 100%">Google</a>
							 	</div>
							</div> 
						</div>
					</div>
					<div class="card col-md-6 hidden-xs hidden-sm text-white bg-primary">
						<div class="card-body text-center">
							<div>
								<h2>Register</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							<a type="button" class="btn btn-info mt-3 br-0" href="{{route('register')}}">Register Now !</a>
							</div>
						</div>
					</div>
				</div>
				
				{{--  <div class="login_header">
					<div class="title">
						<h1 class="text-center">Đăng nhập</h1>
						<h3 class="text-center">Đăng nhập nhanh bằng tài khoản</h3>
					</div>
					<div class="social text-center">
	
						<a class="btn btn-primary" href="{{route('loginProvider','facebook')}}"><i class="fa fa-fw fa-facebook"></i>Sign in with Facebook</a>
						<a class="btn btn-danger" href="{{route('loginProvider','google')}}"><i class="fa fa-fw fa-google"></i>Sign in with Google</a>
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
					<form role="form" name="frmLogin" method="post" action="{{route('login')}}">
						<div class="form-group">
							<input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}">
							@if($errors->has('email'))
							<p style="color: red">{{$errors->first('email')}}</p>
							@endif
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="password" placeholder="Password">
							@if($errors->has('password'))
							<p style="color: red">{{$errors->first('password')}}</p>
							@endif
						</div>
						{{ csrf_field() }}
						<button type="submit" class="btn btn-primary btn-login">Đăng nhập</button>
						
					</form>
				</div>
				<hr>
				<div class="register text-center">
					<h4>Bạn chưa có tài khoản? <a href="#" data-toggle="modal" data-target="#modalRegister" style="color: #337ab7">Đăng ký ngay</a></h4>
					
				</div>  --}}
			</div>
		</div>
		@include('partials.modal-login')
		@include('partials.modal-register')
	</div>
</div>
@stop
@section('footer.js')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
<script src="assets/controller/UsersController.js"></script>

<script src="assets/js/validate-form.js"></script>

@stop