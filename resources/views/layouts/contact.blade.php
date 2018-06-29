@extends('layouts.master')
@section('title')
Contact | ITJob
@stop
@section('body.content')
<div class="maps">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.425458654834!2d106.76665741442872!3d10.855209192268092!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175279e6cfef82b%3A0x511a6cabdb569c1e!2zMTkgxJDGsOG7nW5nIHPhu5EgOCwgTGluaCBUcnVuZywgVGjhu6cgxJDhu6ljLCBI4buTIENow60gTWluaCwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1506357870186" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<div class="wrapper">
	<div class="container">
		<div class="contact">
			<div class="row">
				<div class="col-md-6">
					<form action="{{route('contact')}}" method="POST" id="frmContact" name="frmContact" class="form-horizontal" role="form">
								<div class="form-group">
									<h1>Contact Us</h1>
								</div>
								@if(Session::has('message'))
								<div class="form-group">
									<label for="" class="col-sm-3 control-label"></label>
									<div class="col-sm-9">
										<div class="alert alert-success">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												{{ Session::get('message') }}
										</div>
									</div>
								</div>
								@endif
								<div class="form-group">
									<label for="" class="col-sm-3 control-label">Your Email <span class="red-star">*</span></label>
									<div class="col-sm-9">
										<input type="email" id="email" name="email" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-3 control-label">Your Name </label>
									<div class="col-sm-9">
										<input type="text" id="name" name="name" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-3 control-label">Subtitle <span class="red-star">*</span></label>
									<div class="col-sm-9">
										<input type="text" id="subtitle" name="subtitle" class="form-control">
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label for="" class="col-sm-3 control-label">Content <span class="red-star">*</span></label>
									<div class="col-sm-9">
										<textarea name="content" id="content" class="form-control" id="" cols="20" rows="10"></textarea>
									</div>
								</div>
								{{csrf_field()}}
								<div class="form-group">
									<div class="col-sm-9 col-sm-offset-3">
										<button type="submit" class="btn btn-google br-0" style="width: 100%">Send</button>
									</div>
								</div>
						</form>
				</div>
				<div class="col-md-6">
					<h1>About Us</h1>
					<div class="wrapper" style="margin: auto; width: 430px; padding-top: 0 !important; line-height: 30px">
				        <div style="padding-left: 15px;">
				            <span style="color: #9c3328; font-weight: bolder; font-size: 20px">ITJob</span>
				            <table style="color: #363f44">
				                <tr>
				                    <td style="color:#0b3e6f; width: 70px;font-weight: bolder">Email</td>
				                    <td><a href="mailto:itjob@hrteam.gmail.com" style="color: #58666e">itjob@hrteam.gmail.com</a></td>
				                </tr>
				                <tr>
				                    <td style="color:#0b3e6f; width: 70px;font-weight: bolder">Tel</td>
				                    <td>(+84 28) 7301 1666</td>
				                </tr>
				                <tr>
				                    <td style="color:#0b3e6f; width: 70px;font-weight: bolder">Hotline</td>
				                    <td><a href="tel:+84907059703" style="color: #58666e">(+84) 1675 94 64 14</a></td>
				                </tr>
				                <tr>
				                    <td style="color:#0b3e6f; width: 70px;font-weight: bolder">Skype</td>
				                    <td><a href="skype:itjob.hrteam?chat" style="color: #58666e">itjob.hrteam</a></td>
				                </tr>
				                <tr>
				                	<td style="color:#0b3e6f; width: 70px;font-weight: bolder">Address</td>
				                    <td colspan="2">1 Vo Van Ngan st. Thu Duc Dist, Ho Chi Minh City, Vietnam
				                    </td>
				                </tr>
				            </table>
				        </div>
    				</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('footer.js')
<script src="assets/js/validate-form.js"></script>
@stop