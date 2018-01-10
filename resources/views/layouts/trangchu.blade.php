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
				<form class="form-inline" role="form" method="get" action="{{route('list-job-search')}}">
					<div class="form-group col-sm-7 col-md-7 keyword-search">
						<i class="fa fa-search" aria-hidden="true"></i>
						<input type="hidden" name="idtp" ng-model="idtp">
						@if(Session::has('skillname'))
						<input type="text" id="keyword" name="keysearch" class="typeahead form-control" value="{{Session::get('skillname')}}" placeholder="Keyword skill (Java, iOS,...),..">
						@else
						<input type="text" id="keyword" name="keysearch" class="typeahead form-control" placeholder="Keyword skill (Java, iOS,...),..">
						@endif
					</div>
					<div class="form-group col-sm-3 col-md-3 location-search">
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						@if(Session::has('city'))
						<input class="form-control dropdown-toggle" id="nametp" name="nametp" placeholder="City" data-toggle="dropdown" value="{{Session::get('city')}}">
						@else
						<input class="form-control dropdown-toggle" id="nametp" name="nametp" placeholder="City" data-toggle="dropdown">
						@endif
						<ul class="dropdown-menu">
							@foreach(Cache::get('listLocation') as $c)
								<li><p id="loca">{{$c->name}}</p></li>
							@endforeach
						</ul>
					</div>
					<div class="form-group col-sm-2 col-md-2">
						<input type="submit" class="btn btn-default btn-search" value="Search" formtarget="_blank">
					</div>	
				</form>
			<div class="list-skill hidden-xs" ng-controller="SkillsController">
					<ul>
						<li ng-repeat="skill in skills"><a href="it-job/<% skill.alias %>"><% skill.name  %>, </a></li>
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
				@foreach($top_emps as $te)
			    <div class="col-md-2 col-xs-6 col-sm-4 col-lg-2">
			        <div class="item">
			            <div class="top-employer__logo text-center">
			                <a href="{{route('getEmployers',$te->alias)}}" target="_blank"><img src="uploads/emp/logo/{{$te->logo}}" alt="" title="" class="property_img"/>
			                </a>
			            </div>
			            <div class="property_details text-center">
			                <a href="{{route('getEmployers',$te->alias)}}" class="top-employer__name" target="_blank">{{$te->name}}</a>
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
												@foreach($top_jobs as $tj)
												<li>
													<a href="{{route('detailjob',[$tj->alias,$tj->id])}}" title="{{$tj->name}}">
											            <span class="job-title">
											            	<strong class="text-clip">{{$tj->name}}</strong>
											            <em class="text-clip">{{$tj->em}}</em></span>
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
@if(!empty(Session::get('error_code')) && Session::get('error_code') == 1)
    <script>$(document).ready(function(){$('#loginModal').modal('show');}); </script>
@endif
@if(!empty(Session::get('error_code')) && Session::get('error_code') == 2)
    <script>$(document).ready(function(){alert('This feature is not available');}); </script>
@endif
@endsection
@section('footer.js')
<script src="assets/js/typeahead.js"></script>
<script src="assets/js/aboutjob.js"></script>
<script src="assets/js/validate-form.js"></script>
<script src="assets/js/typeahead-autocomplete-job.js"></script>
@endsection
