@extends('layouts.master')
@section('title')
	{{$jobs[0]->name}} at {{$jobs[0]->en}}
@endsection
@section('body.content')
<div class="job-details" ng-controller="SkillsController">
    <section class="main-content container">
        <div class="job-header">
            <div class="job-header__list-photo">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <a title="Image 1" href="#">
                            <img class="modal-image img-responsive" id="image-1" src="assets/img/s1.jpg">
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <a title="Image 2" href="#">
                            <img class="modal-image imodal-image mg-responsive " id="image-2" src="assets/img/s2.jpg">
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <a title="Image 3" href="#">
                            <img class="modal-image img-responsive" id="image-3" src="assets/img/s3.jpg">
                        </a>
                    </div>
                    <hr>
		            <div class="hidden" id="img-repo">
		                <!-- #image-1 -->
		                <div class="item" id="image-1">
		                    <img class="thumbnail img-responsive" title="Image 11" src="assets/img/s1.jpg">
		                </div>
		                <div class="item" id="image-1">
		                    <img class="thumbnail img-responsive" title="Image 12" src="assets/img/s2.jpg">
		                </div>
		                <div class="item" id="image-1">
		                    <img class="thumbnail img-responsive" title="Image 13" src="assets/img/s3.jpg">
		                </div>
		                <!-- #image-2 -->
		                <div class="item" id="image-2">
		                    <img class="thumbnail img-responsive" title="Image 21" src="assets/img/s2.jpg">
		                </div>
		                <div class="item" id="image-2">
		                    <img class="thumbnail img-responsive" title="Image 21" src="assets/img/s3.jpg">
		                </div>
		                <div class="item" id="image-2">
		                    <img class="thumbnail img-responsive" title="Image 23" src="assets/img/s1.jpg">
		                </div>

		                <!-- #image-3-->
		                <div class="item" id="image-3">
		                    <img class="thumbnail img-responsive" title="Image 31" src="assets/img/s3.jpg">
		                </div>
		                <div class="item" id="image-3">
		                    <img class="thumbnail img-responsive" title="Image 32" src="assets/img/s2.jpg">
		                </div>
		                <div class="item" id="image-3">
		                    <img class="thumbnail img-responsive" title="Image 33" src="assets/img/s1.jpg">
		                </div>
		            </div>
		            <div class="modal" id="modal-gallery" role="dialog">
		                <div class="modal-dialog">
		                    <div class="modal-content">
		                        <div class="modal-header">
		                            <button class="close" type="button" data-dismiss="modal">×</button>
		                        </div>
		                        <div class="modal-body">
		                            <div id="modal-carousel" class="carousel">
		                                <div class="carousel-inner">
		                                </div>
		                                <a class="carousel-control left" href="#modal-carousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
		                                <a class="carousel-control right" href="#modal-carousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>

		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
        </div>
        <div class="job-content">
        	<div class="row">
        		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pull-left" >
        			<div class="image-employer">
        				<div class="box box-md">
        					<div class="col-md-12">
        						<div class="row">
        							<div class="col-md-8">
        								<div class="row">
        									<div class="job-header__info">
        										<h1 class="job-title">
        											{{$jobs[0]->name}}
        										</h1>
        										<span class="company-name text-lg"><strong>{{$jobs[0]->en}}</strong></span>
        										<div class="block">
        											<span title="Address"><i class="fa fa-home" aria-hidden="true"></i></span>
        											<span class="employer-address">{{$jobs[0]->address}}</span>
        										</div>
        										<div class="block">
        											<span title="Address"><i class="fa fa-cog" aria-hidden="true"></i></span>
        											<span class="employer-address"><strong>Product</strong></span>
        										</div>
        										<div class="block">
        											<span title="Location"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
        											<span class="employer-location"> Hà Nội</span>
        										</div>
        									</div>
        								</div>
        								<div class="row row-salary">
        									<span class="tag-salary">Salary: <strong class="">
        										@if(Auth::check())Negotiable
        										@else <a href="" data-toggle="modal" data-target="#loginModal">Đăng nhập để xem lương</a>
        										@include('partials.modal-login')
        										@endif
        									</strong>
   
        									</span>
        								</div>
        								<div class="row" >
        									<div ng-init="listSkillJob({{$jobs[0]->id}})">
        										<span class="tag-skill" title="<% skill.name %>" ng-repeat="skill in skillsjob"><% skill.name %></span>
        									</div>
        								</div>
        							</div>
        							<div class="col-md-4">
        								<div class="row">
        									<div class="action-apply">
        										<button class="btn btn-primary btn-xlg col-xs-12">Apply Now</button>
        									</div>
        								</div>
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-right">
        			<div class="box">
        				<div class="col-md-12 col-sm-12 employer-logo">
        					<div class="responsive-container box-limit">
        							<a href="{{route('getEmployers',$jobs[0]->el)}}" target="_blank" title="{{$jobs[0]->en}}"><img src="assets/img/LG-logo.png" alt=""></a>
        						
        					</div>
        				</div>
        				<div class="col-md-12 col-sm-12 employer-info">
        					<h3 class="name">{{$jobs[0]->en}}</h3>
        					<div class="basic-info">
        						<div class="short">{{$jobs[0]->ed}}</div>
        						<p><i class="fa fa-home" aria-hidden="true"></i> {{$jobs[0]->address}}</p>
        						<p><i class="fa fa-cog" aria-hidden="true"></i>Product</p>
        					</div>
        					<div class="more_jobs">
        						<div class="current-jobs">
        							<a href="{{route('getEmployers',$jobs[0]->el)}}" target="_blank">
        								<i class="fa fa-arrow-right"></i> More jobs from this employer
        							</a>
        						</div>
        					</div>
        				</div>
        			</div>
        			<div class="box related-jobs">
        				<div class="header-top">
        					<a href="{{route('/')}}">Related Jobs</a>
        				</div>
        				<div class="wrap">
        					<ul class="jobs" ng-init="ralatedJob({{$jobs[0]->id}})">
	        					<li class="item-job">
	        						<a href="" title="{{$jobs[0]->name}}">
	        							<div class="title">{{$jobs[0]->name}}</div>
										<div>
											<span class="company">{{$jobs[0]->en}}</span>
											<span class="location"><i class="fa fa-map-marker"></i> Ha Noi</span>
										</div>
										<div>
											<span class="salary"><i class="fa fa-wifi" aria-hidden="true"></i> @if(Auth::check())Negotiable
    										@else 
    										<a href="" data-toggle="modal" data-target="#loginModal">Đăng nhập để xem lương</a>
    										@include('partials.modal-login')
    										@endif
        									</span>
										</div>
										<div>
											<span class="tag-skill">C++</span>
										</div>
	        						</a>
	        					</li>
	        					<li class="item-job">
	        						<a href="" title="{{$jobs[0]->name}}">
	        							<div class="title">{{$jobs[0]->name}}</div>
										<div>
											<span class="company">{{$jobs[0]->en}}</span>
											<span class="location"><i class="fa fa-map-marker"></i> Ha Noi</span>

										</div>
										<div>
											<span class="salary"><i class="fa fa-wifi" aria-hidden="true"></i> @if(Auth::check())Negotiable
    										@else 
    										<a href="" data-toggle="modal" data-target="#loginModal">Đăng nhập để xem lương</a>
    										@include('partials.modal-login')
    										@endif
        									</span>
										</div>
										<div>
											<span class="tag-skill">C++</span>
											<span class="tag-skill">C++</span>
										</div>
	        						</a>
	        					</li>
        				</ul>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
    </section>
</div>
@endsection
@section('footer.js')
<script src="assets/js/modal-image-gallery.js"></script>
@endsection