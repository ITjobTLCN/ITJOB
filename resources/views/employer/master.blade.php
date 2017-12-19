@extends('layouts.master')
@section('title')
Employer
@endsection
@section('body.content')
<div class="container emp">
	<div class="row">
		<div class="sidebar">
			<div class="sb-head sb-title">
				<a href="">My Employer</a>
			</div>
			<div class="sb-content">
				<div class="sb-block">
					<div class="sb-head">
						<a class="sb-a" href="emp/basic">Basic</a>
					</div>
					<div class="sb-detail">
						<a class="sb-b" href="emp/basic#emp-dashboard" target="_blank"><i class="fa fa-dashboard" ></i> Dashboard</a>
						<a class="sb-b" href="emp/basic#emp-yourpost"><i class="fa fa-sticky-note-o"></i> Your post</a>
					</div>
				</div>
				@if(Auth::user()->role_id==3)
				<div class="sb-block">
					<div class="sb-head">
						<a class="sb-a" href="{{route('getempadvance')}}">Advance</a>
					</div>
					<div class="sb-detail">
						<a class="sb-b" href="emp/advance#emp-info"><i class="fa fa-info-circle"></i> Emp Info</a>
						<a class="sb-b" href="emp/advance#emp-assistant"><i class="fa fa-user-circle"></i> Manage Assistants</a>
						<a class="sb-b" href="emp/advance#emp-post"> <i class="fa fa-sticky-note"></i> Manage Posts</a>
					</div>
				</div>
				@endif
			</div>
		</div>
		<div class="content">
			<div class="ct-title">
				<p>@yield('emptitle')</p>
			</div>
			<div class="ct-content">
				@yield('empcontent')
			</div>
		</div>
	</div>
</div>
@endsection
@section('footer.js')
	<script src="assets/angularjs/controller/EmpMngController.js"></script>
	<script src="assets/js/emp.js"></script>
@endsection