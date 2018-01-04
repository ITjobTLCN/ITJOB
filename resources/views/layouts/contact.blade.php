@extends('layouts.master')
@section('title')
Contact Us | ITJob
@stop
@section('body.content')
<div class="maps">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.425458654834!2d106.76665741442872!3d10.855209192268092!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175279e6cfef82b%3A0x511a6cabdb569c1e!2zMTkgxJDGsOG7nW5nIHPhu5EgOCwgTGluaCBUcnVuZywgVGjhu6cgxJDhu6ljLCBI4buTIENow60gTWluaCwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1506357870186" width="1349" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<div class="wrapper">
	<div class="container">
		<div class="contact">
			<div class="row">
				<div class="col-md-6">
					<form action="" method="POST" id="frmContact" name="frmContact" class="form-horizontal" role="form">
								<div class="form-group">
									<h1>Contact Us</h1>
								</div>
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
								<div class="form-group">
									<div class="col-sm-9 col-sm-offset-3">
										<button type="submit" class="btn btn-danger" style="width: 100%">Send</button>
									</div>
								</div>
						</form>	
				</div>
				<div class="col-md-6">
				<h1>About Us</h1>

				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('footer.js')
<script src="assets/js/app.js"></script>
<script src="assets/controller/UsersController.js"></script>
<script src="assets/controller/SkillsController.js"></script>
@stop