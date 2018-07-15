@extends('layouts.master')
@section('title')
Reviews of top companies on ITJob
@stop
@section('body.content')
<div class="search-companies">
	<div class="container">
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
				<form class="form-inline" role="form" method="get" action="{{route('searchCompaniesByName')}}">
					<div class="form-group col-sm-10 col-md-10 keyword-search">
						<i class="fa fa-search" aria-hidden="true"></i>
						<input type="text" name="q" id="company_name" class="typeahead form-control"  placeholder="Enter Company name">
					</div>
					<div class="form-group col-sm-2 col-md-2">
						<input type="submit" value="Search" class="btn btn-default btn-search" formtarget="_blank">
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="list-companies" ng-controller="CompanyController">
	<div class="companies-hiring-now container">
		<div class="title">
			<h1>Companies hiring now</h3>
			<h3>This is list companies that is most concerned</h2>
		</div>
		<div class="list-companies clearfix">
			@foreach($comHirring as $ch)
			<div class="col-md-4 col-sm-4 col-lg-4">
				<a href="{{route('getEmployers', $ch->alias)}}" class="company" target="_blank">
					<div class="company_banner">
						<img src="uploads/emp/cover/{{$ch->images['cover']}}" alt="Cover-photo" class="img-responsive image" title="{{$ch->name}}" class="property_img"/>
					</div>
					<div class="company_info">
						<div class="company_header">
							<div class="company_logo">
								<img src="uploads/emp/avatar/{{$ch->images['avatar']}}" alt="avatar-company">
							</div>
							<div class="company_name">
								{{$ch->name}}
							</div>
						</div>
						<div class="company_desc">{{$ch->employer_info['description']}}</div>
						<div class="company_footer">
							<i class="fa fa-star" aria-hidden="true"></i>
							<span class="company_start_rate"> {{$ch->rating}}</span>
							<span class="company_city">
								{{$ch->address[0]['city']}}
							</span>
						</div>
					</div>
				</a>
			</div>
			@endforeach
		</div>
		@if(count($comHirring) > 6)
		<a href="" id="see-more-hiring" class="dotted" ng-click="seeMoreCompany('hirring')">See more  <i class="fa fa-caret-down" aria-hidden="true"></i></a>
		@endif
	</div>
	<div class="seperate"></div>
	<div class="most-followed-companies container">
		<div class="title">
			<h1>Most followed companies</h3>
			<h3>This is list companies that is the most followed</h2>
		</div>
		<div class="list-companies clearfix">
			@foreach($comFollow as $cf)
			<div class="col-md-4 col-sm-4 col-lg-4">
				<a href="{{route('getEmployers', $cf->alias)}}" class="company" target="_blank">
					<div class="company_banner">
						<img src="uploads/emp/cover/{{$cf->images['cover']}}" alt="Cover-photo" class="img-responsive image" title="{{$cf->name}}" class="property_img"/>
					</div>
					<div class="company_info">
						<div class="company_header">
							<div class="company_logo">
								<img src="uploads/emp/avatar/{{$cf->images['avatar']}}" alt="avatar-company">
							</div>
							<div class="company_name">
								{{$cf->name}}
							</div>
						</div>
						<div class="company_footer">
							<i class="fa fa-star" aria-hidden="true"></i>
							<span class="company_start_rate"> {{$cf->rating}}</span>
							<span class="company_city">
								{{$cf->address[0]['city']}}
							</span>
						</div>
					</div>
				</a>
			</div>
			@endforeach
			<div class="more-most-followed"></div>
		</div>
		@if(count($comFollow) > 6)
		<a href="" id="see-more-most-followed" class="dotted" ng-click="seeMoreCompany('follow')">See more  <i class="fa fa-caret-down" aria-hidden="true"></i></a>
		@endif
			</div>
	</div>
</div>
@stop
@section('footer.js')
<script src="assets/js/typeahead.js"></script>
<script src="assets/js/typeahead-autocomplete.js"></script>
<script src="assets/controller/CompanyController.js"></script>
@stop