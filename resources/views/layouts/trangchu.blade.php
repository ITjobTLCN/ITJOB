@extends('layouts.master')
@section('title')
ITJob - Top Job IT For You
@stop
@section('header.caption')
<div class="hero">
	<div class="caption">
		<div class="search-widget wrapper clearfix">
			<div class="row">
				<h2>Tìm Công Việc Mơ Ước. Nâng Bước Thành Công!</h2>
			</div>
			<div class="row">
				<form class="form-inline" role="form">
					<div class="form-group col-sm-7 col-md-7 keyword-search">
						<i class="fa fa-search" aria-hidden="true"></i>
						<input type="email" class="form-control"  placeholder="Keyword skill (Java, iOS,...),..">
						<div class="keyword-search">
						</div>
					</div>
					<div class="form-group col-sm-3 col-md-3 location-search" >
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<input class="form-control dropdown-toggle" placeholder="City" data-toggle="dropdown">
						<ul class="dropdown-menu" ng-controller="CityController">
							<li ng-repeat="city in cities"><a href="#" ><% city.name %></a></li>
						</ul>
					</div>
					<div class="form-group col-sm-2 col-md-2">
						<button type="submit" class="btn btn-default btn-search">Search</button>
					</div>	
				</form>
			</div>
		</div>
	</div>
	<div class="main-menu">
		<div class="wrapper">
			<nav>
				<ul class="hidden-xs" ng-controller="SkillsController">
					<li ng-repeat="skill in skills"><a href="#"><% skill.name %></a></li>
				</ul>
			</nav>
		</div>
	</div>
</div>
@stop
@section('body.content')
<div class="container">
	<section class="listings">
		<div class="wrapper">
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
		</div>
	</section>	<!--  end listing section  -->
</div>
@stop
@section('footer.js')
<script src="assets/controller/UsersController.js"></script>
<script src="assets/controller/CityController.js"></script>
<script src="assets/controller/SkillsController.js"></script>
<script>
</script>
@stop
