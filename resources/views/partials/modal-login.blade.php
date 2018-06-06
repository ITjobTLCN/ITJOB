
<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title text-center" id="exampleModalLongTitle">
					<div class="login_header">
						<div class="title">
							<h1 class="text-center">Đăng nhập</h1>
							<h3 class="text-center">Đăng nhập hoặc đăng ký thành viên nhanh bằng tài khoản</h3>
						</div>
						<div class="social text-center">
							<a type="button" href="{{route('loginProvider','facebook')}}" class="btn btn-primary"><i class="fa fa-fw fa-facebook"></i> Facebook</a>
							<a type="button" href="{{route('loginProvider','google')}}" class="btn btn-danger"><i class="fa fa-fw fa-google"></i> Google</a>
						</div>
					</div>
				</h5>
			</div>
			<div class="modal-body">
				<div class="modal_content">
					<div class="login_content ">
						<h4 class="text-center">Đăng nhập bằng tài khoản ITJob</h4>
						<form role="form" name="frmLogin" id="frmLogin">
							<div class="alert alert-danger alert-dismissible error">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							 	<span class="errorLogin"></span>
							</div>
							<div class="form-group">

								<input type="email" class="form-control" name="email" id="email" placeholder="Email">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="password" id="password" placeholder="Password">
							</div>
							{{ csrf_field() }}
							<button type="submit" class="btn btn-primary" style="width: 100%">Đăng nhập</button>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<h4 class="text-center">Bạn chưa có tài khoản? <a href="{{route('register')}}" style="color: #337ab7">Đăng ký ngay</a></h4>
				</div>
			</div>
		</div>
	</div>
</div>
