@extends('layouts.master')
@section('title')
ITJob - Top Job IT For You
@endsection
@section('header.caption')
<div class="hero">
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
		</ol>
		<!-- Wrapper for slides -->
		<div class="carousel-inner">
			<div class="item active">
				<img src="assets/img/banner-1.jpg" alt="banner 1" class="img-responsive">
				<div class="carousel-caption">
					<h3>Los Angeles</h3>
					<p>LA is always so much fun!</p>
				</div>
			</div>

			<div class="item">
				<img src="assets/img/banner-2.jpg" alt="banner 2" class="img-responsive">
				<div class="carousel-caption">
					<h3>Chicago</h3>
					<p>Thank you, Chicago!</p>
				</div>
			</div>
			<div class="item">
				<img src="assets/img/banner-3.jpg" alt="banner 2" class="img-responsive">
				<div class="carousel-caption">
					<h3>Chicago</h3>
					<p>Thank you, Chicago!</p>
				</div>
			</div>
		</div>
	</div>
	<div class="caption">
		<div class="search-widget container clearfix">
			<h2>Find your dream jobs. Be success !</h2>
			<div class="row">
				@include('partials.search-job')
				<div class="list-skill hidden-xs" ng-controller="SkillsController">
					<ul>
						<li ng-repeat="skill in skills">
							<a href="it-job/<% skill.alias %>" target="_blank"><% skill.name  %>, </a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('body.content')
	<div class="container">
		<section class="top_employers">
			<h1 class="title text-center">Top Employees</h1>
			<div class="row top-employers__list">
				@foreach($top_emps as $top_emp)
			    <div class="col-md-2 col-xs-6 col-sm-4 col-lg-2">
			        <div class="item">
			            <div class="top-employer__logo text-center">
			                <a href="{{route('getEmployers', $top_emp->alias)}}" target="_blank"><img src="uploads/emp/logo/{{$top_emp->images['avatar']}}" alt="" title="" class="property_img"/>
			                </a>
			            </div>
			            <div class="property_details text-center">
			                <a href="{{route('getEmployers', $top_emp->alias)}}" class="top-employer__name" target="_blank">{{$top_emp->name}}</a>
			            </div>
			        </div>
			    </div>
			    @endforeach
			</div>
		</section>	<!--  end listing section  -->
		<section class="our_jobs">
			<h1 class="title text-center">Our Job</h1>
			<div class="our-jobs__main">
				<div class="row">
					<div class="col-md-9">
						<div class="top-jobs__list">
							<span class="title">Top Jobs</span>
							<br>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane tab-job" id="topJobs">
									<div class="panel-content">
										<div class="job-list">
											<ul>
												@foreach($top_jobs as $top_job)
												<li>
													<a href="{{route('detailjob', [$top_job->alias, $top_job->_id])}}" title="{{$top_job->name}}">
											            <span class="job-title">
											            	<strong class="text-clip">{{$top_job->name}}</strong>
											            	<em class="text-clip">{{$top_job->employer['name']}}</em>
											            </span>
										 			</a>
												</li>
												@endforeach
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="tech-event">
							<span class="title">Tech Events</span>
						</div>
					</div>
				</div>
			</div>
		</section>
		@include('partials.advertiment')
		@include('partials.modal-login')
		@include('partials.modal-register')
	</div>
{{-- @if(!empty(Session::get('error_code')) && Session::get('error_code') == 1)
    <script>$(document).ready(function(){$('#loginModal').modal('show');}); </script>
@endif
@if(!empty(Session::get('error_code')) && Session::get('error_code') == 2)
    <script>$(document).ready(function(){alert('This feature is not available');}); </script>
@endif --}}
@endsection
@section('footer.js')
<script src="assets/controller/SearchController.js"></script>
<script src="assets/js/aboutjob.js"></script>
<script src="assets/js/validate-form.js"></script>
<script src="assets/js/typeahead.js"></script>
<script src="assets/js/typeahead-autocomplete.js"></script>
@endsection
