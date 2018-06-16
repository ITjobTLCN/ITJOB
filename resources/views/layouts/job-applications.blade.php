@extends('layouts.master')
@section('title')
Application Jobs | ITJob
@endsection
@section('body.content')
<div class="job-applications" ng-controller="JobsController">
	<div class="search-widget container clearfix">
		<div id="serach-widget ">
			<div class="bg-blue container">
				<div class="row">
					<h2>Find your dream jobs. Be success!</h2>
				</div>
				<div class="row" id="search-form">
					@include('partials.search-job')
				</div>
			</div>
		</div>
	</div>
	<div class="applied-jobs container">
		<div id="save-jobs" class="col-md-9 col-sm-12">
			@if(count($jobApplications) == 0)
			<div class="no-jobs">
				<h1 class="no-jobs-title">You have 0 Applied Jobs</h1>
				<h2 class="no-jobs-caption text-center">OMG - You haven't applied for any jobs yet.</h2>
				<div class="no-jobs-image text-center">
					<img src="https://cdn.itviec.com/assets/robby-applied-jobs-46cfdba3e7a6cedca2036541bc0936f9b82a4114ccc13d9e1d5981c5d589585e.png" alt="Robby applied jobs">
				</div>
			</div>
			@else
			<div class="list-applied-job" id="job-list">
				<h1 class="jobs-title">You have {{count($jobApplications)}} Applied Jobs</h1>
				@foreach($jobApplications as $ja)
				<div class="job-item">
					<div class="row" >
						<div class="col-xs-12 col-sm-2 col-md-3 col-lg-2" >
							<div class="logo job-search__logo jb-search__result">
								<a href=""><img title="{{$ja->employer['name']}}" class="img-responsive" src="uploads/emp/avatar/{{$ja->employer['images']['avatar']}}" alt="">
								</a>
							</div>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<div class="job-item-info" >
								<h3 class="bold-red">
									<a href="{{route('detailjob', [$ja->alias, $ja->_id])}}" class="job-title" title="{{$ja->name}}">{{$ja->name}}</a>
								</h3>
								<div class="company">
									<span class="job-search__company">{{$ja->employer['name']}}</span>
									<span class="separator">|</span>
									<span class="job-search__location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{$ja->city}}</span>
								</div>
								<div class="company text-clip">
									<span class="salary-job">
										@if(Auth::check())
										{{ $ja->job['detail']['salary'] }} $
										@else
										<a href="" data-toggle="modal" data-target="#loginModal">Đăng nhập để xem lương</a>
										@endif
									</span>
									<span class="separator">|</span>
									<span class="">@if(date('d-m-Y') == date('d-m-Y', strtotime($ja->created_at))) Today @else {{date('d-m-Y', strtotime($ja->created_at))}}@endif</span>
								</div>
								<div class="job__skill">
									@foreach (app(App\Http\Controllers\JobsController::class)->getListSkillJobv($ja->job['skills_id']) as $key => $s)
									<a href=""><span>{{ $s->name }}</span></a>
									@endforeach
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			@endif
		</div>
		@include('partials.top-emps')
	</div>
</div>
@endsection
@section('footer.js')
<script src="assets/controller/SearchController.js"></script>
<script src="assets/controller/JobsController.js"></script>
<script src="assets/js/typeahead.js"></script>
<script src="assets/js/typeahead-autocomplete.js"></script>
@endsection