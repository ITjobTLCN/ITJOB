@extends('companies.master')
@section('title')
{{$company->name}} | ITJob
@stop
@section('body.content')
<div class="detail-companies" ng-controller="CompanyController">
	<div class="wrapper">
		{{-- home --}}
		<section class="home-companies">
			<div class="cover-photo_company" id="home">
				<img src="{{asset('assets/img/episerver-headline-photo-compress.jpg')}}" alt="" class="img-responsive">
			</div>
			<div class="profile-header_company">
				<div class="row">
					<div class="col-md-2 col-sm-3 col-xs-12">
						<div class="logo-company">
							<img src="{{asset('assets/img/episerver-logo-170-151.png')}}" alt="" class="img-responsive">
						</div>
					</div>
					<div class="col-md-7 col-sm-6 col-xs-12">
						<div class="name-info">
							<h2 id="name-company">{{$company->name}}</h2>
							<div class="location">
								<h3><span><i class="fa fa-location-arrow" aria-hidden="true"></i> {{$company->address}}</span></h3>
							</div>
							<div class="num-employee">
								<h3><span data-toggle="tooltip" title="Personel"><i class="fa fa-users" aria-hidden="true"></i> 100-200</span></h3>
							</div>
							<div class="see-maps">
								<a href=""><h3><i class="fa fa-map" aria-hidden="true"></i> See on map</h3></a>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						@if(Auth::check())
						<div class="followed" ng-click="follow({{$company->id}})">
							<a class="btn btn-danger" ng-init="countFollow({{$company->id}})">Follow (<%cFollow%>)</a>
						</div>
						@else
						<div class="followed" bs-popover>
							<a class="btn btn-danger" rel="popover">Follow ({{$company->follow}})</a>
						</div>
						@include('partials.modal-login')
						@endif
					</div>
				</div>
			</div>
		</section>
		<section class="reviews-companies">
			<div id="reviews">
				<div class="header-section">
					<h1>About Us</h1>
					<span class="under-line"></span>
				</div>
				<div class="about-company">
					<div class="row" id="description">
						<div class="col-md-6 col-sm-12">
							<div class="paragraph">
								<p>BIM là một trong những tập đoàn kinh tế tư nhân đa ngành tại Việt Nam, có trụ sở chính tại Thành Phố Hạ Long, Tỉnh Quảng Ninh. Tập đoàn được thành lập từ năm 1994 bởi Ông Đoàn Quốc Việt - một doanh nhân đã thành công trong nhiều lĩnh vực tại Ba Lan trước khi ông quyết định đầu tư tại Việt Nam.</p>
								<p>Trong quá trình xây dựng và phát triển, tập đoàn BIM đã mở rộng mô hình kinh doanh và tập trung vào ba lĩnh vực chính là: Phát triển Du lịch và Đầu tư Bất động sản, Nông nghiệp - Thực phẩm và Dịch vụ Thương mại. Hiện nay, tập đoàn BIM và các đơn vị thành viên đang đầu tư và hoạt động trên phần lớn các tỉnh thành của Việt Nam với đội ngũ cán bộ công nhân viên lên đến 3.000 người.</p> 
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="image-company">
								<div class="row">
									<div class="col-md-6 col-sm-6"><img src="{{asset('assets/img/BIM_Group-Office-2.png')}}" alt=""></div>
									<div class="col-md-6 col-sm-6"><img src="{{asset('assets/img/BIM_Group-Office-3.png')}}" alt=""></div>
									<div class="col-md-6 col-sm-6"><img src="{{asset('assets/img/BIM_Group-Office-4.png')}}" alt=""></div>
									<div class="col-md-6 col-sm-6"><img src="{{asset('assets/img/BIM_Group-Office-2.png')}}" alt=""></div>
								</div>
							</div>
						</div>
					</div>
					<div id="skills">
						<h2 class="title">All Our Tag Skills</h2>
						<ul>
							@foreach($skills as $skill)
							<li class="employer-skills__item">
								<a href="{{route('seachjob',[$skill->alias,4])}}" target="_blank">{{$skill->name}}</a>
							</li>
							@endforeach
						</ul>
					</div>
					<div id="ratings">
						<h2 class="title">Ratings</h2>
					</div>
				</div>

			</div>
			<!-- End row -->
		</section>
		<section class="hiring-now-companies">
			<div id="hiring-now">
				<div class="header-section">
					<h1>Hiring Now</h1>
					<span class="under-line"></span>
				</div>
				<div class="list-job-hiring">
					<input type="hidden" value="{{$company->id}}" id="company_id">
					{{-- <p id="show-jobs">click me</p> --}}
					<div class="title">
						<a data-toggle="collapse" id="up-down" href="#list-job-content">{{count($jobs)}} Jobs waiting for you <span><i class="fa fa-arrow-down" aria-hidden="true"></i></span></a>
					</div>
					<div id="list-job-content" class="panel-collapse collapse">
						@foreach($jobs as $job)
							<div class="job-item">
								<div class="job-item-info">
		                            <div class="row">
		                                <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
		                                    <h3>
		                                        <a href="" class="job-title" target="_blank">{{$job->name}}</a>
		                                    </h3>
		                                    <ul>
		                                    	<li><i class="fa fa-calendar" aria-hidden="true"></i> {{$job->created_at}}</li>
		                                    	<li><i class="fa fa-calendar" aria-hidden="true"></i> {{$job->created_at}}</li>
		                                    	<li><i class="fa fa-money" aria-hidden="true"></i> Login to see salary</li>
		                                    	<li></li>
		                                    </ul>
		                                    <div class="company text-clip">
		                                        {{-- <span class="job-search__company">'.$tem->en.' </span>
		                                        <span class="separator">|</span>
		                                        <span class="job-search__location">'.$tem->cn.'</span> --}}
		                                    </div>
		                                </div>
		                                <div class="hidden-xs col-sm-2 col-md-2 col-lg-2 view-detail">
		                                    <a href="" target="_blank" >Detail</a>
		                                </div>
		                            </div>
                            	</div>
                            </div>
						@endforeach
						<div class="load-more-job">
							<a href="" id="see-more-job-company">See more</a>
						</div>
					</div>
					<div id="result-jobs"></div>

				</div>
			</div>
			<!-- End row -->
		</section>
	</div>
</div>
@stop
@section('footer.js')
<script src="{{asset('assets/js/myscript.js')}}"></script>
<script src="{{asset('assets/controller/SkillsController.js')}}"></script>
<script src="{{asset('assets/controller/CompanyController.js')}}"></script>
@stop