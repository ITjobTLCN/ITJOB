@extends('layouts.master')
@section('title')
Search for all it Jobs in Vietnam
@stop
@section('body.content')	
<div class="all-jobs">
	<div class="container all-jobs" ng-controller="JobsController">
		@include('partials.search-job')
		<div id="job-search" class="job-search">
			<div class="container-fluid">
				<div class="row">
					<div id="left-column" class="hidden-xs col-sm-3 col-md-3 col-lg-2">
						<div class="box box-xs">
							<h2>Filter by</h2>
							<div class="list-filter-att clearfix">
								<div class="edition-filter clearfix"></div>
								<a href="" ><div class="clear-all-filter-att" ng-click="clearall()">Xóa</div></a>
							</div>

							<div id="locations" class="facet">
								<h5 data-target="#list-locations" data-toggle="collapse">locations </h5>
								<div id="list-locations" class="collapse in">
									<ul>
										<li ng-repeat="city in cities">
											<input type="checkbox" ng-true-value="'<%city.name%>'" ng-false-value="''" ng-click="toggleSelection($event,'cities',city.id,city.name,city.alias)" ng-checked="checkedl"><span><%city.name%></span>
										</li>
									</ul>
								</div>
							</div>
							<div id="skills" class="facet" ng-controller="SkillsController">
								<h5 data-toggle="collapse" data-target="#list-skills">skills</h5>
								<div id="list-skills" class="collapse in">
									<ul>
										<li ng-repeat="skill in skills">
											<input type="checkbox" ng-true-value="'<%skill.name%>'" ng-false-value="''" ng-checked="checkeds" ng-click=" toggleSelection($event,'skills',skill.id,skill.name,skill.alias)"><span><%skill.name%></span>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div id="main-job-list" class="col-sm-9 col-md-9 col-lg-10">
						<div class="box m-b-none">
							<div class="job-search__top-nav">
								<div class="row">
									<div class="col-xs-12 col-md-6 col-lg-12">
										<h2>@if(Session::has('countjob'))
											{{Session::has('countjob')}}
											@else {{count($listJobLastest)}} IT Jobs for you </h2>
											 @endif
									</div>
									<div class="col-xs-12 col-md-6 col-lg-5"></div>
								</div>
							</div>
						</div>
						<div id="job-list" class="jb-search__result">
							@foreach($listJobLastest as $ljlt)
							<div class="job-item" bs-popover>
								<div class="row" >
									<div class="col-xs-12 col-sm-2 col-md-3 col-lg-2" >
										<div class="logo job-search__logo jb-search__result">
											<a href=""><img title="" class="img-responsive" src="assets/img/logo-search-job.jpg" alt="">
											</a>
										</div>
									</div>
									<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
										<div class="job-item-info" >
											<h3 class="bold-red">
												<a href="{{route('detailjob',[$ljlt->alias,$ljlt->id])}}" class="job-title" target="_blank">{{$ljlt->name}}</a>
											</h3>
											<div class="company text-clip">
												<span class="job-search__company">{{$ljlt->en}}</span>
												<span class="separator">|</span>
												<span class="job-search__location">{{$ljlt->cn}}</span>
											</div>
											<div class="description-job">
												<h3><% job.job_description %></h3>
											</div>
											<div class="company text-clip">
												<span class="salary-job"><a href="{{route('login')}}">Đăng nhập để xem lương</a></span>
												<span class="separator">|</span>
												<span class="">Hôm nay</span>
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="col-xs-12 col-sm-2 col-md-1 col-lg-2">
										@if(Auth::check())
										<div class="follow{{$ljlt->id}}" id="followJob" emp_id="{{$ljlt->employer_id}}" job_id="{{$ljlt->id}}">
											@if(app(App\Http\Controllers\JobsController::class)->getJobFollowed($ljlt->id)==1)
												<i class="fa fa-heart" aria-hidden="true" data-toggle="tooltip" title="UnFollow"></i>
											@else
											<i class="fa fa-heart-o" aria-hidden="true" data-toggle="tooltip" title="Follow"></i>
											@endif
										</div>
										@else
										<i class="fa fa-heart-o" aria-hidden="true" rel="popover"></i>
										@endif
									</div>
								</div>	
							</div>
							@endforeach
							@include('partials.modal-login')
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
<script src="assets/controller/UsersController.js"></script>
<script src="assets/controller/JobsController.js"></script>

<script src="assets/js/aboutjob.js"></script>
<script src="assets/js/typeahead.js"></script>
<script src="assets/js/typeahead-autocomplete-job.js"></script>
@stop