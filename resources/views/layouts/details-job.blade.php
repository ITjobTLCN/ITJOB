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
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <a title="Image 1" href="#">
                            <img class="modal-image img-responsive" id="image-1" src="assets/img/s1.jpg">
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <a title="Image 2" href="#">
                            <img class="modal-image imodal-image mg-responsive " id="image-2" src="assets/img/s2.jpg">
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
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
		                            <button class="closeModal" type="button" data-dismiss="modal">×</button>
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
        											<span class="employer-location"> {{$jobs[0]->cn}}</span>
        										</div>
        									</div>
        								</div>
        								<div class="row row-salary">
        									<span class="tag-salary">Salary: <strong class="">
        										@if(Auth::check()) {{$jobs[0]->salary}}
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
        										<a href="{{route('getApplyJob',[$jobs[0]->alias,$jobs[0]->el,$jobs[0]->id])}}" class="btn btn-primary btn-xlg col-xs-12">Apply Now</a>
        									</div>
        								</div>
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
                    {{-- Job Detail --}}
                    <div id="job-detail" class="job-info">
                        <div class="box box-md">
                            {{-- Job Description --}}
                            <h2>The Job</h2>
                            <div id="job-description" class="push-top-sm">
                                {{$jobs[0]->description}}
                            </div>
                            {{-- Job Requirement --}}
                            <h2>Your Skills and Experience</h2>
                            <div id="job-requirement">
                                {{$jobs[0]->require}}
                            </div>
                            <h2 class="pull-left">Benifit</h2>
                            <div class="clearfix"></div>
                            {{-- Benifits --}}
                            <div class="job-benifit push-top-xs">
                                <div class="border-primary">
                                    <div class="benifit-name">
                                        <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="benefit-icon">
                                                                <i class="fa fa-fw fa-lg fa-dollar" title="Bonus"></i>
                                                            </div>
                                                            <div class="benefit-name">Bonus: 13th month salary &amp; Performance bonus.</div>
                                                        </div>
                                                    </div>
                                                                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="benefit-icon">
                                                                <i class="fa fa-fw fa-lg fa-user-md" title="Healthcare Plan"></i>
                                                            </div>
                                                            <div class="benefit-name">Healthcare for you &amp; your family.</div>
                                                        </div>
                                                    </div>
                                                                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="benefit-icon">
                                                                <i class="fa fa-fw fa-lg fa-gift" title="Vouchers"></i>
                                                            </div>
                                                            <div class="benefit-name">Training: Language training, Local Workshop, International Workshop, On-site training.</div>
                                                        </div>
                                                    </div>
                                                                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="benefit-icon">
                                                                <i class="fa fa-fw fa-lg fa-graduation-cap" title="Training"></i>
                                                            </div>
                                                            <div class="benefit-name">Taking part in the on going projects and get on job training to quickly level up to senior level.</div>
                                                        </div>
                                                    </div>
                                                                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="benefit-icon">
                                                                <i class="fa fa-fw fa-lg fa-plane" title="Travel Opportunities"></i>
                                                            </div>
                                                            <div class="benefit-name">Company activities: Annual company trip, Sport activities (Football, swimming, badminton, billiard, yoga, etc.).</div>
                                                        </div>
                                                    </div>
                                                                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="benefit-icon">
                                                                <i class="fa fa-fw fa-lg fa-child" title="Kindergarten"></i>
                                                            </div>
                                                            <div class="benefit-name">Studying and working with cutting edge technologies.</div>
                                                        </div></div>
                                        {{$jobs[0]->treatment}}
                                    </div>
                                </div>
                            </div>
                            <h2>Technologies We're using</h2>
                            <div id="Technology">
                                <div ng-init="listSkillCompanies({{$jobs[0]->emp_id}})">
                                    <span class="tag-skill" title="<% skill.name %>" ng-repeat="skill in skillsemp"><% skill.name %></span>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-xlg col-xs-12 apply">Apply Now</button>
                        </div>
                    </div>
                    @include('partials.job-most-viewer')
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
        			@include('partials.related-jobs')
        		</div>
        	</div>
        </div>
    </section>
</div>
@endsection
@section('footer.js')
<script src="assets/js/modal-image-gallery.js"></script>
<script src="assets/js/validate-form.js"></script>
@endsection