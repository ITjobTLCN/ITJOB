@extends('layouts.master')
@section('title')
	All Companies in Vietnam
@stop
@section('body.content')
<div class="search-companies">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{route('/')}}">Home</a>
                </li>
                <li class="active">Companies</li>
            </ol>
        </div>
        <div class="search-companies-main">
            <div class="title">
                <h1>COMPANY</h1>
                <h3>Discover about companies and choose the best place to work for you.</h3>
            </div>
            <div class="search-widget clearfix">
                <form class="form-inline search-companies" role="form" method="get" action="{{route('searchCompaniesbyname')}}">
                    <div class="form-group col-sm-10 col-md-10 keyword-search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input type="text" name="company_name" id="company_name" class="typeahead form-control" placeholder="Enter Company name">
                    </div>
                    <div class="form-group col-sm-2 col-md-2">
                        <button type="submit" class="btn btn-default btn-search" formtarget="_blank">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="container">
    <div class="companies">
        <div class="row">
            <div class="col-md-8" id="list-companies">
                <div class="num-companies">
					<span>{{count($companies)}} companies</span>
                </div>
                @foreach($companies as $com)
                <div class="companies-item">
                    <div class="row">
                        <div class="col-xs-3 col-md-3 col-lg-2">
                            <div class="logo job-search__logo">
                                <a href=""><img title="" class="img-responsive" src="assets/img/logo-search-job.jpg" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-8 col-md-8 col-lg-8">
                            <div class="companies-item-info">
                                <a href="{{route('getEmployers',$com->alias)}}" class="companies-title" target="_blank">{{$com->name}}</a>
                                <div class="company text-clip">
                                    <span class="job-search__location">{{$com->address}}</span>
                                </div>
                                <div class="description-job">
                                    <h3>{{$com->description}}</h3>
                                </div>
                                <div class="company text-clip">
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
                @endforeach
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
</div>
@stop
@section('footer.js')
<script src="assets/js/myscript.js"></script>
<script src="assets/js/typeahead.js"></script>
<script src="assets/js/typeahead-autocomplete-company.js"></script>
@stop