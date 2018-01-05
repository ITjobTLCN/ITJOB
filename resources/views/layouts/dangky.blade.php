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
					<h4 class="text-center">Đăng ký thành viên để tiếp cận nhanh hơn với nhà tuyển dụng</h4>
				</div>
				<div class="social text-center">

					<button class="btn btn-primary"><i class="fa fa-fw fa-facebook"></i> Facebook</button>
					<button class="btn btn-danger"><i class="fa fa-fw fa-google"></i> Google</button>
				</div>
			</div>
			<hr>
			<div class="login_content text-center">
				<h4>Đăng nhập bằng tài khoản ITJob</h4>
				<form id="frmRegister">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<p style="color: red;display: none;" class="error errorRegister"></p>
						<div class="form-group">
							<input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
						</div>
						<div class="form-group">
							<input type="email" class="form-control" name="email" id="email" placeholder="Email">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="password" id="password" placeholder="Password">
						</div>
						<input type="hidden" name="">
						
						<input type="submit" class="btn-primary form-control" value="Đăng ký">
						
					</form>
			</div>
			<hr>
			<div class="register text-center">
				<h4>Bạn đã có tài khoản ITJob? <a href="#" style="color: #337ab7">Đăng nhập ngay</a></h4>
			</div>
		</div>
		<div class="col-md-3"></div>
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