@extends('layouts.master')
@section('body.content')
<div class="jumbotron">
	<div class="container text-center">
		<h1 class="display-4">Register</h1>
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
			<form action="{{route('postregister')}}" method="POST">
				<div class="form-group row">
					<label for="name" class="col-sm-2 form-control-label">Name</label>
					<div class="col-sm-10">
						<input type="text" name="name" class="form-control" placeholder="Name" value="{{old('name')}}" >
					</div>
				</div>
				<div class="form-group row">
					<label for="email" class="col-sm-2 form-control-label">Email</label>
					<div class="col-sm-10">
						<input type="email" name="email" class="form-control" placeholder="Email" value="{{old('email')}}" >
					</div>
				</div>
				<div class="form-group row">
					<label for="password" class="col-sm-2 form-control-label">Password</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password" placeholder="Password" value="{{old('password')}}" >
					</div>
				</div>
				<div class="form-group row">
					<label for="re-password" class="col-sm-2 form-control-label">Re-Password</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password_confirmation" placeholder="Retype password" value="{{old('password_confirmation')}}" >
					</div>
				</div>


				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div class="form-group row text-center">
					<div class=" col-md-5 text-center ">
						<button type="submit" class="btn btn-secondary">Create Account</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- endcontent -->
<hr>
@endsection