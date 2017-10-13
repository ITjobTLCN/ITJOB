@extends('layouts.master')
@section('title')
Search for all it Jobs in Vietnam
@stop
@section('body.content')	
<div class="all-jobs">
    <div class="container all-jobs" ng-controller="JobsController">
    <div class="wrapper">
        <div class="search-widget wrapper clearfix">
            <div class="row">
                <h2>Find your dream jobs. Be success!</h2>
            </div>
            <div class="row">
                <form class="form-inline" role="form">
                    <div class="form-group col-sm-7 col-md-7 keyword-search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input type="email" id="keyword-skill" class="form-control" placeholder="Keyword skill (Java, iOS,...),..">
                        <div id="result-search-job">
							<ul class="search-job">
							</ul>
						</div>
                    </div>
                    <div class="form-group col-sm-3 col-md-3 location-search">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <input class="form-control dropdown-toggle" placeholder="City" data-toggle="dropdown">
                        <ul class="dropdown-menu">
                            <li ng-repeat="city in cities">
                                <a href="">
                                    <% city.name %>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="form-group col-sm-2 col-md-2">
                        <button type="submit" class="btn btn-default btn-search">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="job-search" class="job-search">
            <div class="container-fluid">
                <div class="row">
	                    <div id="left-column" class="hidden-xs col-md-3 col-sm-4 col-lg-3">
	                        <div class="box box-xs">
	                            <h2>Filter by</h2>
	                            <div class="edition-filter">
	                            	
	                            </div>
	                            <div id="locations" class="facet">
	                                <h5 data-target="#list-locations" data-toggle="collapse">locations </h5>
	                                <div id="list-locations" class="collapse in">
	                                    <ul>
	                                        <li ng-repeat="city in cities">
											   <input type="checkbox" ng-model="checked" ng-true-value="'<%city.name%>'" ng-false-value="''" ng-click="toggleSelection($event,'cities',city.id,city.name,city.alias)"><span><%city.name%></span>
											 </li>
	                                    </ul>
	                                </div>
	                            </div>
	                            <div id="skills" class="facet" >
	                                <h5 data-toggle="collapse" data-target="#list-skills">skills</h5>
	                                <div id="list-skills" class="collapse in">
	                                    <ul>
	                                        <li ng-repeat="skill in skills">
											   <input type="checkbox" ng-model="myCountry.selected[skill.id]" ng-true-value="'<%skill.name%>'" ng-false-value="''" ng-click="toggleSelection($event,'skill',skill.id,skill.name,skill.alias)"><span><%skill.name%></span>
											 </li>
	                                    </ul>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="clearfix"></div>
	                    </div>
                    <div id="main-job-list" class="col-xs-12 col-md-9 col-sm-8 col-lg-9">
                        <div class="box m-b-none">
                        	<div class="job-search__top-nav">
                        		<div class="row">
                        			<div class="col-xs-12 col-md-6 col-lg-7">
                        				<h2>@if(Session::has('listBySkillName')) 
                        					{{$countjobSkillName}} Jobs for you
                        				@else {{$countjob}} IT Jobs for you </h2>
                        				@endif
                        			</div>
                        			<div class="col-xs-12 col-md-6 col-lg-5"></div>
                        		</div>
                        		
                        	</div>
                        </div>
                        <div id="job-list" class="jb-search__result">
                        	@if(Session::has('listBySkillName'))
                        		@foreach(Session::get('listBySkillName') as $lbsn)
                        		
                        		<div class="job-item">
		                            <div class="row" >
		                                <div class="col-xs-3 col-md-3 col-lg-2" >
		                                    <div class="logo job-search__logo">
		                                        <a href=""><img title="" class="img-responsive" src="assets/img/logo-search-job.jpg" alt="">
		                                        </a>
		                                    </div>
		                                </div>
		                                <div class="col-xs-8 col-md-8 col-lg-8">
		                                    <div class="job-item-info" >
		                                        <h3 class="bold-red">
		                                            <a href="{{route('detailjob',[$lbsn->alias,$lbsn->id])}}" class="job-title" target="_blank">{{$lbsn->name}}</a>
		                                        </h3>
		                                        <div class="company text-clip">
		                                            <span class="job-search__company">{{$lbsn->en}}</span>
		                                            <span class="separator">|</span>
		                                            <span class="job-search__location">{{$lbsn->cn}}</span>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="col-xs-1 col-md-1 col-lg-2">
		                                    <span data-toggle="tooltip" data-placement="left" title="Follow"><i class="fa fa-heart-o" aria-hidden="true"></i></span>
		                                </div>
		                            </div>	
	                        	</div>
	                        	@endforeach
                        	@else
                        	<div class="job-item" ng-repeat="job in jobs">
	                            <div class="row" >
	                                <div class="col-xs-3 col-md-3 col-lg-2" >
	                                    <div class="logo job-search__logo">
	                                        <a href=""><img title="" class="img-responsive" src="assets/img/logo-search-job.jpg" alt="">
	                                        </a>
	                                    </div>
	                                </div>
	                                <div class="col-xs-8 col-md-8 col-lg-8">
	                                    <div class="job-item-info" >
	                                        <h3 class="bold-red">
	                                            <a href="it-job/<% job.alias %>-<% job.id %>" class="job-title" target="_blank"><% job.name %></a>
	                                        </h3>
	                                        <div class="company text-clip">
	                                            <span class="job-search__company"><% job.en %></span>
	                                            <span class="separator">|</span>
	                                            <span class="job-search__location"><% job.cn %></span>
	                                        </div>
	                                        <div class="description-job">
	                                        	<h3><% job.job_description %></h3>
	                                        </div>
	                                        <div class="company text-clip">
	                                        	<span class="salary-job"><a href="{{route('login')}}">Đăng nhập để xem lương</a></span>
	                                        	<span class="separator">|</span>
	                                            <span class="">Hôm nay</span>
	                                        </div>
	                                    </div>
	                                    <div class="clearfix"></div>
	                                </div>
	                                <div class="col-xs-1 col-md-1 col-lg-2">
	                                    <span data-toggle="tooltip" data-placement="left" title="Follow"><i class="fa fa-heart-o" aria-hidden="true"></i></span>
	                                </div>
	                            </div>
	                        </div>
                        	@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop
@section('footer.js')
<script src="assets/controller/JobsController.js"></script>
<script src="assets/js/myscript.js"></script>
@stop