@extends('layouts.master')
@section('title')
Đăng ký tài khoản	
@stop
@section('header.css')
<link rel="stylesheet" type="text/css" href="assets/less/card.less">
@stop
@section('body.content')
<div class="container">
<div class="wrapper">
	<div class="form-card">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<div class="card-group">
					<div class="card text-white bg-default">
						<div class="card-body">
							<h1>Đăng ký</h1>
							<p class="text-muted mb-3">Tạo tài khoản của bạn</p>
							{{--  <div class="social text-center mb-3">
								<a class="btn btn-primary" href="{{route('loginProvider','facebook')}}"><i class="fa fa-fw fa-facebook"></i>Facebook</a>
								<a class="btn btn-danger" href="{{route('loginProvider','google')}}"><i class="fa fa-fw fa-google"></i>Google</a>
							</div>  --}}
							<form role="form" name="frmLogin" method="post" action="{{route('login')}}">
								<div class="input-group mb-3">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input type="text" class="form-control" name="name" 
										placeholder="Your name">
								</div>
								<div class="input-group mb-3">
									<span class="input-group-addon">@</span>
									<input type="email" class="form-control" name="email" placeholder="Email">
								</div>
								<div class="input-group mb-3">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
									<input type="password" class="form-control" name="password" 
										placeholder="Password">
								</div>
								<div class="input-group mb-3">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
									<input type="password" class="form-control" name="repeatPassword" 
										placeholder="Repeat password">
								</div>
								{{ csrf_field() }}
								<button type="submit" class="btn btn-success btn-block br-0">Tạo tài khoản</button>
								
							</form>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-6">
									<a class="btn btn-primary btn-block br-0" href="{{route('loginProvider','facebook')}}">
										<i class="fa fa-fw fa-facebook fl"></i>Facebook</a>
								
								</div>
								<div class="col-md-6">
									<a class="btn btn-danger btn-block br-0" href="{{route('loginProvider','google')}}">
										<i class="fa fa-fw fa-google fl"></i>Google</a>
								</div>
							</div>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@stop
@section('footer.js')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
<script src="assets/controller/UsersController.js"></script>

<script src="assets/js/validate-form.js"></script>

@stop