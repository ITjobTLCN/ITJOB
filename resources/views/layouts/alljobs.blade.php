@extends('layouts.master')
@section('title')
Search for all dream Jobs in Vietnam | ITJOB
@stop
@section('body.content')
<div class="all-jobs" ng-controller="JobsController">
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
	<div id="job-search" class="job-search">
		<div class="container-fluid">
			<div class="row">
				<div id="left-column" class="hidden-xs col-sm-3 col-md-3 col-lg-2">
					<div class="box box-xs">
						<h2>Filter by</h2>
						<button class="btn btn-facebook br-0" ng-click="clearAll()"> Clear All</button>
						<div id="locations" class="facet">
							<h5 data-target="#list-locations" data-toggle="collapse">salary </h5>
							<div id="list-locations" class="collapse in">
								<ul>
									<li ng-repeat="sala in salary">
										<input type="radio" name="salary" ng-click="filterJob($event, 'salary', sala)" ng-disabled="disableFilter(<?php echo (count($listJobLastest)) ?>)"><span><% sala.label %></span>
									</li>
								</ul>
							</div>
						</div>
						<div id="skills" class="facet">
							<h5 data-toggle="collapse" data-target="#list-skills">skills</h5>
							<div id="list-skills" class="collapse in">
								<ul>
									<li ng-repeat="skill in skills">
										<input type="checkbox" ng-click="filterJob($event, 'skills', skill)" ng-model="skill.selected" ng-disabled="disableFilter(<?php echo (count($listJobLastest)) ?>)" ><span><%skill.name%></span>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div id="main-job-list" class="col-sm-7 col-md-7 col-lg-8">
					@if(!$match)
					<div id="no-results-message">
						<h2 class="text-center">
							<p>Oops!, we could not find matching jobs for your search at this moment. </p>
							Please try with another keyword choice.
							<p style="margin-top: 10px; font-size: 18px">Here are some new jobs for you.</p>
						</h2>
					</div>
					@include('partials.recommend_jobs')
					@else
					<div class="box m-b-none" id="countjob">
						<div class="job-search__top-nav">
							<div class="row">
								<div class="col-xs-12 col-md-6 col-lg-12">
									<h2 ><span class="countjob">{{ $countjob }}</span> IT Jobs for you </h2>
								</div>
							</div>
						</div>
					</div>
					<div id="job-list" class="jb-search__result">
						@foreach($listJobLastest as $ljlt)
						<div class="job-item">
							<div class="row" >
								<div class="col-xs-12 col-sm-2 col-md-3 col-lg-2 job-search__logo-col">
									<div class="logo job-search__logo jb-search__result">
										<a href="{{ route('getEmployers', $ljlt->employer['alias']) }}" target="_blank">
											<img class="img-responsive" src="uploads/emp/avatar/{{ $ljlt->employer['images']['avatar'] }}" title="{{ $ljlt->employer['name'] }}"></a>
									</div>
								</div>
								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
									<div class="job-item-info" >
										<h3 class="bold-red">
											<a href="{{ route('detailjob',[$ljlt->alias, $ljlt->_id]) }}" class="job-title" target="_blank">{{ $ljlt->name }}</a>
										</h3>
										<div class="company">
											<span class="job-search__company">{{ $ljlt['employer']['name']}}</span>
											<span class="separator">|</span>
											<span class="job-search__location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $ljlt->city}}</span>
										</div>
										<div class="company text-clip">
											<span class="salary-job">
												{{ $ljlt->detail['salary'] ?? '0' }} $
											</span>
											<span class="separator">|</span>
											<span class="">@if(date('d-m-Y') == date('d-m-Y', strtotime($ljlt->created_at))) Today @else {{date('d-m-Y', strtotime($ljlt->created_at))}}@endif</span>
										</div>
										<div class="job__skill">
											@foreach (app(App\Http\Controllers\JobsController::class)->getListSkillJobv($ljlt->skills_id) as $key => $s)
											<span>{{ $s->name }}</span>
											@endforeach
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
								@if(!Auth::check() || Auth::user()->role_id == '5ac85f51b9068c2384007d9c')
								<div class="col-xs-12 col-sm-2 col-md-1 col-lg-2">
									@if(Auth::check())
									<div class="follow{{ $ljlt->_id }}" id="followJob" emp_id="{{ $ljlt->employer_id }}" job_id="{{ $ljlt->_id }}">
										@if(app(App\Http\Controllers\JobsController::class)->getJobFollowed($ljlt->_id))
										<i class="fa fa-heart" aria-hidden="true" title="UnFollow"></i>
										@else
										<i class="fa fa-heart-o" aria-hidden="true" title="Follow"></i>
										@endif
									</div>
									@else
									<i class="fa fa-heart-o" aria-hidden="true" id="openLoginModal" title="Login to follow"></i>
									@endif
								</div>
								@endif
							</div>
						</div>
						@endforeach
						@if($countjob > 20)
						<button id="show-more-jobs" ng-click="showMoreJob()">Show more...</button>
						@endif
					</div>
					@endif
				</div>
				<div id="right-column" class="hidden-xs hidden-sm col-md-2 col-lg-2">
					<div class="box m-b-none">
						<div class="job-search__adver">
						</div>
					</div>
				</div>
				@include('partials.modal-login')
				@include('partials.modal-register')
			</div>
		</div>
	</div>
</div>
@stop
@section('footer.js')
<script src="assets/controller/SearchController.js"></script>
<script src="assets/controller/JobsController.js"></script>
<script src="assets/js/aboutjob.js"></script>
<script src="assets/js/validate-form.js"></script>
<script src="assets/js/typeahead.js"></script>
<script src="assets/js/typeahead-autocomplete.js"></script>
@stop