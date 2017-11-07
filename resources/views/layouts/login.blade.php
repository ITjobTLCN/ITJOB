@extends('layouts.master')
@section('title')
	Login | ITJob
@endsection
@section('body.content')
		<div class="jumbotron">
			<div class="container text-center">
				<h1 class="display-4">Login</h1>
				<p class="lead">This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
			</div>
		</div>
		
		<!-- content -->
		<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				<div class="title">
					<h4 class="text-center">Đăng nhập hoặc đăng ký thành viên nhanh bằng tài khoản</h4>
				</div>
				<div class="social text-center">
					<a type="button" href="{{route('loginProvider','facebook')}}" class="btn btn-primary"><i class="fa fa-fw fa-facebook"></i>Sign in with Facebook</a>
					<a type="button" href="{{route('loginProvider','google')}}" class="btn btn-danger"><i class="fa fa-fw fa-google"></i>Sign in with Google</a>
				</div>
				<div class="login_content text-center">
					<h4 class="text-center">Đăng nhập bằng tài khoản ITJob</h4>
					@if(Session::has('message'))
						<p style="color:red; padding-left: 100px;">{{Session::get('message')}}</p>
					@endif
					<form action="{{route('postlogin')}}" method="POST">
						<div class="form-group row">
							<label for="email" class="col-sm-2 form-control-label">Email</label>
							<div class="col-sm-10">
								<input type="email" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">
							</div>
						</div>
						<div class="form-group row">
							<label for="password" class="col-sm-2 form-control-label">Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" name="password" placeholder="Password" value="{{old('password')}}">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-2"></label>
							<div class="col-sm-10">
								<div class="checkbox">
									<label>
										<input type="checkbox"> Remember me?
									</label>
								</div>
							</div>
						</div>
						{{csrf_field()}}
						{{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
						<div class="form-group row justify-content-center">
							<div class=" col-md-5 text-center ">
								<button type="submit" class="btn btn-secondary ">Sign in</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
			
		</div>
		<!-- endcontent -->
		
		<hr>
@endsection