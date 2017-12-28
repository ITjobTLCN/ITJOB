
<!-- Modal -->
<div class="modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title text-center" id="exampleModalLongTitle">
					<div class="login_header">
						<div class="title">
							<h1>Đăng ký</h1>
						</div>
						<div class="social text-center">
							<a type="button" href="{{route('loginProvider','facebook')}}" class="btn btn-primary"><i class="fa fa-fw fa-facebook"></i> Dùng tài khoản Facebook</a>
							<a type="button" href="{{route('loginProvider','google')}}" class="btn btn-danger"><i class="fa fa-fw fa-google"></i> Dùng tài khoản Google</a>
						</div>
					</div>
				</h5>
			</div>
			<div class="modal-body">
				
				<h4 class="text-center">Đăng ký bằng EMAIL</h4>
				<div class="modal_content ">
					<form role="form" id="frmRegister">
						<p style="color: red;display: none;" class="error errorRegister"></p>
						<div class="form-group">
							<input type="text" class="form-control" name="namer" id="namer" placeholder="Your Name">
						</div>
						<div class="form-group">
							<input type="email" class="form-control" name="emailr" id="emailr" placeholder="Email">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="passwordr" id="passwordr" placeholder="Password">
						</div>
						{{ csrf_field() }}
						<input type="submit" class="btn-primary form-control" id="btnSubmit" value="Đăng ký">
						
					</form>
				</div>
			</div>

			<div class="modal-footer text-center">
				<h4>Bạn là thành viên ITJobs ?<a id="clickModalLogin" href="#" style="color: #337ab7"> Đăng nhập</a></h4>
				
			</div>
		</div>
	</div>
</div>
