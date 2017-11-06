@extends('home.layout.master')
@section('content')
	<div class="jumbotron">
			<div class="container text-center">
				<h1 class="display-4">Register A Employer</h1>
				<p class="lead">This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
			</div>
		</div>
		
		<!-- content -->
		<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				@if(Session::has('message'))
					<p style="color:red; padding-left: 100px;">{{Session::get('message')}}</p>
				@endif
				@if ($errors->any())
				    <div class="alert alert-danger">
				        {{ $errors->first()}}       
				    </div>
				@endif
				<form action="{{route('postregisteremp')}}" method="POST" id="register_emp_form">
					<input type="hidden" name="emp_id" value="-1">
					<div class="form-group row">
						<label for="name" class="col-sm-3 form-control-label">Employer Name:</label>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-8">
									<input type="text" name="name" class="form-control" placeholder="Employer name" value="{{old('name')}}">
								</div>
								<div class="col-4">
									<a href="#" class="btn btn-outline-info w-100" data-toggle="modal" data-target="#modal-choose-employer" id="suggest-btn">OR Choose one</a>
									<button type="button" class="btn btn-outline-info w-100" id="create-btn" style="display: none">Create one</button>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="website" class="col-sm-3 form-control-label">Employer Website:</label>
						<div class="col-sm-9">
							<input type="text" name="website" class="form-control" placeholder="Link website" value="{{old('website')}}" >
						</div>
					</div>
					<div class="form-group row">
						<label for="address" class="col-sm-3 form-control-label">Address:</label>
						<div class="col-sm-9">
							<input type="text" name="address" class="form-control" placeholder="Address" value="{{old('address')}}" >
						</div>
					</div>	


					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="form-group row justify-content-center">
						<div class=" col-md-5 text-center ">
							<button type="submit" class="btn btn-secondary w-75">Send Request</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		
			
		</div>
		<!-- endcontent -->
		<hr>


		<!-- model choose one employer -->
		<div class="modal fade" id="modal-choose-employer">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<h4 class="modal-title">Choose one employer</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col">
								<input type="text" placeholder="Type your employer" class="form-control" id="register_emp_suggest">
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col">
								<h3>Suggest</h3>
								<ul class="list-suggest-emp">
									<div class="m-3">
										<span class="float-right"><button type="button" data-val="1" class="btn btn-sm btn-outline-info select-suggest-emp">Chọn em</button></span>
										<a href="" target="_blank"><h5 class="over">AAA</h5></a>
									</div>									
								</ul>
								
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- END model choose one employer -->
@endsection