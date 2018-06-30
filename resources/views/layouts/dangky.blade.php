@extends('layouts.master')
@section('title')
ITJob - Đăng ký tài khoản
@endsection
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
							<div class="alert alert-danger" style="display: none">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<p class="errRegister"></p>
							</div>
							<div class="alert alert-success" style="display: none">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<p class="successRegister"></p>
							</div>
							<form role="form" name="frmRegister" id="frmRegister" method="post" action="{{route('login')}}">
								<div class="input-group mb-3">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input type="text" class="form-control" name="name" id="name"
										placeholder="Your name">
								</div>
								<div class="input-group mb-3">
									<span class="input-group-addon">@</span>
									<input type="email" class="form-control" name="email" id="email"
									 placeholder="Email">
								</div>
								<div class="input-group mb-3">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
									<input type="password" class="form-control" name="password" id="password"
										placeholder="Password">
								</div>
								<div class="input-group mb-3">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
									<input type="password" class="form-control" name="repeatPassword" id="repeatPassword"
										placeholder="Repeat password">
								</div>
								{{ csrf_field() }}
								<button type="submit" class="btn btn-success btn-block br-0">Tạo tài khoản</button>
							</form>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<a class="btn btn-facebook btn-block br-0" href="{{route('loginProvider','facebook')}}">
										<i class="fa fa-fw fa-facebook fl"></i>Facebook</a>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<a class="btn btn-google btn-block br-0" href="{{route('loginProvider','google')}}">
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