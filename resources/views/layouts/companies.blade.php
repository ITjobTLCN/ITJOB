@extends('layouts.master')
@section('title')
Reviews of top companies on ITJob
@stop
@section('body.content')
<div class="search-companies">
	<div class="wrapper">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="{{route('/')}}">Home</a></li>
				<li><a href="{{route('companies')}}">Companies</a></li>
				<li class="active">Search</li>
			</ol>
		</div>
		<div class="search-companies-main">
			<div class="title">
				<h1>COMPANY REVIEWS</h1>
				<h3>Discover about companies and choose the best place to work for you.</h3>
			</div>
			<div class="search-widget clearfix">
				<form class="form-inline search-companies" role="form" method="POST">
					<div class="form-group col-sm-10 col-md-10 keyword-search">
						<i class="fa fa-search" aria-hidden="true"></i>
						<input type="email" name="company_name" id="company_name" class="form-control"  placeholder="Enter Company name">
						<div id="result-search-company">
							<ul class="search-company">
							</ul>
						</div>
					</div>
					<div class="form-group col-sm-2 col-md-2">
						<button type="submit" class="btn btn-default btn-search">Search</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="list-companies">
	<div class="companies-hiring-now wrapper container">
		<div class="title">
			<h1>Companies hiring now</h3>
			<h3>This is list companies that is most concerned</h2>
		</div>
		<div class="list-companies clearfix">
			<div class="col-md-4">
				<a href="" class="company">
					<div class="company_banner">
						<img src="assets/img/property_1.jpg" alt="Cover-photo" class="img-responsive image" title="" class="property_img"/>
					</div>
					<div class="company_info">
						<div class="company_header">
							<div class="company_logo">
								<img src="https://itviec.com/system/production/employers/logos/100/fpt-software-logo-65-65.png?1459494092" alt="avatar-company">
							</div>
							<div class="company_name">
								FPT Software
							</div>
						</div>
						<div class="company_desc">One of the leading technical IT group in Asia</div>
						<div class="company_footer">
							<i class="fa fa-star" aria-hidden="true"></i>
							<span class="company_start_rate"> 4.0</span>
							<span class="company_city">
								Ho Chi Minh
							</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="" class="company">
					<div class="company_banner">
						<img src="assets/img/property_1.jpg" alt="Cover-photo" class="img-responsive image" title="" class="property_img"/>
					</div>
					<div class="company_info">
						<div class="company_header">
							<div class="company_logo">
								<img src="https://itviec.com/system/production/employers/logos/100/fpt-software-logo-65-65.png?1459494092" alt="avatar-company">
							</div>
							<div class="company_name">
								FPT Software
							</div>
						</div>
						<div class="company_desc">One of the leading technical IT group in Asia</div>
						<div class="company_footer">
							<i class="fa fa-star" aria-hidden="true"></i>
							<span class="company_start_rate"> 4.0</span>
							<span class="company_city">
								Ho Chi Minh
							</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="" class="company">
					<div class="company_banner">
						<img src="assets/img/property_1.jpg" alt="Cover-photo" class="img-responsive image" title="" class="property_img"/>
					</div>
					<div class="company_info">
						<div class="company_header">
							<div class="company_logo">
								<img src="https://itviec.com/system/production/employers/logos/100/fpt-software-logo-65-65.png?1459494092" alt="avatar-company">
							</div>
							<div class="company_name">
								FPT Software
							</div>
						</div>
						<div class="company_desc">One of the leading technical IT group in Asia</div>
						<div class="company_footer">
							<i class="fa fa-star" aria-hidden="true"></i>
							<span class="company_start_rate"> 4.0</span>
							<span class="company_city">
								Ho Chi Minh
							</span>
						</div>
					</div>
				</a>
			</div>
			<div class="more-hiring"></div>
		</div>
		<a href="" id="see-more-hiring">See more  <i class="fa fa-caret-down" aria-hidden="true"></i></a>
	</div>
	<div class="seperate"></div>
	<div class="most-followed-companies wrapper container">
		<div class="title">
			<h1>Most followed companies</h3>
			<h3>This is list companies that is the most followed</h2>
		</div>
		<div class="list-companies clearfix">
			<div class="col-md-4">
				<a href="" class="company">
					<div class="company_banner">
						<img src="assets/img/property_1.jpg" alt="Cover-photo" class="img-responsive image" title="" class="property_img"/>
					</div>
					<div class="company_info">
						<div class="company_header">
							<div class="company_logo">
								<img src="https://itviec.com/system/production/employers/logos/100/fpt-software-logo-65-65.png?1459494092" alt="avatar-company">
							</div>
							<div class="company_name">
								FPT Software
							</div>
						</div>
						<div class="company_desc">One of the leading technical IT group in Asia</div>
						<div class="company_footer">
							<i class="fa fa-star" aria-hidden="true"></i>
							<span class="company_start_rate"> 4.0</span>
							<span class="company_city">
								Ho Chi Minh
							</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="" class="company">
					<div class="company_banner">
						<img src="assets/img/property_1.jpg" alt="Cover-photo" class="img-responsive image" title="" class="property_img"/>
					</div>
					<div class="company_info">
						<div class="company_header">
							<div class="company_logo">
								<img src="https://itviec.com/system/production/employers/logos/100/fpt-software-logo-65-65.png?1459494092" alt="avatar-company">
							</div>
							<div class="company_name">
								FPT Software
							</div>
						</div>
						<div class="company_desc">One of the leading technical IT group in Asia</div>
						<div class="company_footer">
							<i class="fa fa-star" aria-hidden="true"></i>
							<span class="company_start_rate"> 4.0</span>
							<span class="company_city">
								Ho Chi Minh
							</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="" class="company">
					<div class="company_banner">
						<img src="assets/img/property_1.jpg" alt="Cover-photo" class="img-responsive image" title="" class="property_img"/>
					</div>
					<div class="company_info">
						<div class="company_header">
							<div class="company_logo">
								<img src="https://itviec.com/system/production/employers/logos/100/fpt-software-logo-65-65.png?1459494092" alt="avatar-company">
							</div>
							<div class="company_name">
								FPT Software
							</div>
						</div>
						<div class="company_desc">One of the leading technical IT group in Asia</div>
						<div class="company_footer">
							<i class="fa fa-star" aria-hidden="true"></i>
							<span class="company_start_rate"> 4.0</span>
							<span class="company_city">
								Ho Chi Minh
							</span>
						</div>
					</div>
				</a>
			</div>
			<div class="more-most-followed"></div>
		</div>
		<a href="" id="see-more-most-followed">See more  <i class="fa fa-caret-down" aria-hidden="true"></i></a>
			</div>
	</div>
</div>
@stop
@section('footer.js')
<script src="assets/js/myscript.js"></script>
@stop