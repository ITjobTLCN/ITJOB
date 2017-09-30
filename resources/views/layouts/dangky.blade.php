@extends('layouts.master')
@section('title')
Đăng ký tài khoản	
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
					<h1 class="text-center">Đăng ký thành viên</h1>
					<h4 class="text-center">Đăng thành viên để tiếp cận nhanh hơn với nhà tuyển dụng</h4>
				</div>
				<div class="social text-center">

					<button class="btn btn-primary"><i class="fa fa-fw fa-facebook"></i> Facebook</button>
					<button class="btn btn-danger"><i class="fa fa-fw fa-google"></i> Google</button>
				</div>
			</div>
			<hr>
			<div class="login_content text-center">
				<h4>Đăng nhập bằng tài khoản ITJob</h4>
				<form action="" method="POST" role="form">
					<div class="form-group">
						<input type="text" class="form-control" id="" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="" placeholder="Password">
					</div>
					<button type="submit" class="btn btn-primary btn-login">Đăng nhập</button>
				</form>
			</div>
			<hr>
			<div class="register text-center">
				<h4>Bạn chưa có tài khoản? <a href="#" style="color: #337ab7">Đăng ký ngay</a></h4>
			</div>
		</div>
		<div class="col-md-3"></div>
		</div>
	</div>
</div>
</div>
@stop