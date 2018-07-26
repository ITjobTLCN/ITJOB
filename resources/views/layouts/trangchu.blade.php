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
							<a href="it-job?key=<% skill.alias %>&cid=ho-chi-minh" target="_blank"><% skill.name  %>, </a>
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
		<h1 class="title text-center">Top Employers</h1>
		<div class="row top-employers__list">
			@foreach($top_emps as $top_emp)
		    <div class="col-md-2 col-xs-6 col-sm-4 col-lg-2">
		        <div class="item">
		            <div class="top-employer__logo text-center">
		                <a href="{{route('getEmployers', $top_emp->alias)}}" target="_blank"><img src="uploads/emp/avatar/{{$top_emp->images['avatar']}}" alt="" title="" class="property_img"/>
		                </a>
		            </div>
		            <div class="property_details text-center" style="padding: 0 10px">
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
				<div class="col-md-9 col-sm-12">
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
				<div class="col-md-3 col-sm-12">
					<div class="tech-event">
						<span class="title">Tech Events</span>
						<br>
						<div class="tab-content">
							<div class="tabpanel">
								<div class="panel-content">
                                    <a href="{{route('commingSoon')}}" title="MEETUP.VN - THẺ THAM DỰ TECH EVENT KHÔNG GIỚI HẠN 12 THÁNG">
                                		<img class="img-responsive" src="https://static.getticket.vn/uploads/banner/12_THANG.png">
                            		</a>
                                	<a href="{{route('commingSoon')}}" title="MEETUP.VN - THẺ THAM DỰ TECH EVENT KHÔNG GIỚI HẠN 3 THÁNG">
                                		<img class="img-responsive" src="https://static.getticket.vn/uploads/banner/3_THANG1.png">
                            		</a>
                                	<a href="{{route('commingSoon')}}" title="VIETNAM WEB SUMMIT 2018">
                                		<img class="img-responsive" src="https://static.getticket.vn/uploads/banner/vws_20181.jpg">
                            		</a>
                                    <a href="{{route('commingSoon')}}" title="Khóa Học Khởi Nghiệp Thương Mại Điện Tử Cho Cá Nhân Và SME">
                                		<img class="img-responsive" src="https://static.getticket.vn/uploads/banner/Khoi_Nghiep_TMDT2.png">
                            		</a>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	@include('partials.advertiment')
</div>
@endsection
@section('footer.js')
<script src="assets/controller/SearchController.js"></script>
<script src="assets/js/aboutjob.js"></script>
<script src="assets/js/validate-form.js"></script>
<script src="assets/js/typeahead.js"></script>
<script src="assets/js/typeahead-autocomplete.js"></script>
@endsection
