@extends('layouts.master')
@section('title')
ITJob - Top Job IT For You
@stop
@section('header.caption')

<div class="hero">
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
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
		</div>
	</div>
	<div class="caption">
		<div class="search-widget container clearfix">
			<div class="row">
				<h2>Find your dream jobs. Be success !</h2>
			</div>
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
							{{-- @foreach($cities as $c)
								<li><p id="loca">{{$c->name}}</p></li>
							@endforeach --}}
						</ul>
					</div>
					<div class="form-group col-sm-2 col-md-2">
						<input type="submit" class="btn btn-default btn-search" value="Search" formtarget="_blank">
					</div>	
				</form>
			</div>
		</div>
	</div>
</div>
@stop
@section('body.content')
<div class="container">
	<section class="listings">
		<div class="title">
			<h1>Top Employees</h1>
		</div>
		<ul class="properties_list">
			<li>
				<a href="#">
					<img src="assets/img/property_1.jpg" alt="" title="" class="property_img"/>
				</a>
				<span class="price">$2500</span>
				<div class="property_details text-center">
					<h1>
						<a href="#" >Fuisque dictum tortor at purus libero</a>
					</h1>
					<h2>4 Jobs - <span class="address-companies">Ho Chi Minh</span></h2>
				</div>
			</li>
			<li>
				<a href="#">
					<img src="assets/img/property_2.jpg" alt="" title="" class="property_img"/>
				</a>
				<span class="price">$1000</span>
				<div class="property_details text-center">
					<h1>
						<a href="#">Fuisque dictum tortor at purus libero</a>
					</h1>
					<h2>2 kitchens, 2 bed, 2 bath... <span class="property_size">(288ftsq)</span></h2>
				</div>
			</li>
			<li>
				<a href="#">
					<img src="assets/img/property_3.jpg" alt="" title="" class="property_img"/>
				</a>
				<span class="price">$500</span>
				<div class="property_details text-center">
					<h1>
						<a href="#">Fuisque dictum tortor at purus libero</a>
					</h1>
					<h2>2 kitchens, 2 bed, 2 bath... <span class="property_size">(288ftsq)</span></h2>
				</div>
			</li>
			<li>
				<a href="#">
					<img src="assets/img/property_1.jpg" alt="" title="" class="property_img"/>
				</a>
				<span class="price">$2500</span>
				<div class="property_details text-center">
					<h1>
						<a href="#">Fuisque dictum tortor at purus libero</a>
					</h1>
					<h2>2 kitchens, 2 bed, 2 bath... <span class="property_size">(288ftsq)</span></h2>
				</div>
			</li>
			<li>
				<a href="#">
					<img src="assets/img/property_2.jpg" alt="" title="" class="property_img"/>
				</a>
				<span class="price">$1000</span>
				<div class="property_details text-center">
					<h1>
						<a href="#">Fuisque dictum tortor at purus libero</a>
					</h1>
					<h2>4 Jobs - <span class="address-conpanies">Ho Chi Minh</span></h2>
				</div>
			</li>
			<li>
				<a href="#">
					<img src="assets/img/property_3.jpg" alt="" title="" class="property_img"/>
				</a>
				<span class="price">$500</span>
				<div class="property_details text-center">
					<h1>
						<a href="#">Fuisque dictum tortor at purus libero</a>
					</h1>
					<h2>4 Jobs - <span class="address-conpanies">Ho Chi Minh</span></h2>
				</div>
			</li>
			<li>
				<a href="#">
					<img src="assets/img/property_1.jpg" alt="" title="" class="property_img"/>
				</a>
				<span class="price">$2500</span>
				<div class="property_details text-center">
					<h1>
						<a href="#">Fuisque dictum tortor at purus libero</a>
					</h1>
					<h2>4 Jobs - <span class="address-conpanies">Ho Chi Minh</span></h2>
				</div>
			</li>
			<li>
				<a href="#">
					<img src="assets/img/property_2.jpg" alt="" title="" class="property_img"/>
				</a>
				<span class="price">$1000</span>
				<div class="property_details text-center">
					<h1>
						<a href="#">Fuisque dictum tortor at purus libero</a>
					</h1>
					<h2>4 Jobs - <span class="address-conpanies">Ho Chi Minh</span></h2>
				</div>
			</li>
			<li>
				<a href="#">
					<img src="assets/img/property_3.jpg" alt="" title="" class="property_img"/>
				</a>
				<span class="price">$500</span>
				<div class="property_details text-center">
					<h1>
						<a href="#">Fuisque dictum tortor at purus libero</a>
					</h1>
					<h2>2 kitchens, 2 bed, 2 bath... <span class="property_size">(288ftsq)</span></h2>
				</div>
			</li>
		</ul>
		<div class="more_listing">
			<a href="#" class="more_listing_btn">View More Listings</a>
		</div>
	</section>	<!--  end listing section  -->
</div>
@stop
@section('footer.js')
<script src="assets/js/typeahead.js"></script>
<script src="assets/js/aboutjob.js"></script>
<script src="assets/js/typeahead-autocomplete-job.js"></script>
@stop
