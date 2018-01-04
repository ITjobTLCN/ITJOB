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
                <form class="form-inline role="form" method="get" action="{{route('searchCompaniesbyname')}}">
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
           <div class="col-md-9" id="list-companies">
            <table class="table table-striped">
                <tbody>
                    <div class="num-companies">
                        <span>{{count($companies)}} companies</span>
                    </div>
                    @foreach($companies as $com)
                    <tr>
                        <td>
                            <div class="companies-item">
                                <div class="row">
                                    <div class="col-xs-3 col-md-3 col-lg-2">
                                        <div class="logo job-search__logo">
                                            <a href=""><img title="" class="img-responsive" src="assets/img/logo-search-job.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-9 col-md-9 col-lg-9">
                                        <div class="companies-item-info">
                                            <a href="{{route('getEmployers',$com->alias)}}" class="companies-title" target="_blank">{{$com->name}}</a>
                                            <div class="company text-clip">
                                                <span class="job-search__location">{{$com->address}}</span>
                                            </div>
                                            <div class="description-job">
                                                <h3>{{$com->description}}</h3>
                                            </div>
                                            <div class="company text-clip">
                                                <span class="people"><i class="fa fa-users" aria-hidden="true"></i> 100</span>
                                                <span class="website"><i class="fa fa-desktop" aria-hidden="true"></i> {{$com->website}}</span>
                                            </div>
                                            <div id="skills">
                                                <ul>
                                                    @foreach (app(App\Http\Controllers\CompanyController::class)->getListSkillEmployer($com->id) as $key => $s)
                                                    <li class="employer-skills__item">
                                                        <a href="" target="_blank">{{$s}}</a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="sum-job">
                                                <a href="{{route('getEmployers',$com->alias)}}" id="job" class="dotted">{{$com->total}} jobs </a><i class="fa fa-caret-down" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>
                           <div class="companies-item" id="more-companies">
                               
                           </div>         
                        </td>
                    </tr>
                </tbody>

            </table>
            <div class="loading text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
            <div class="load-more">
                <a href="" id="see-more-companies">Show More</a>
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>
</div>
@stop
@section('footer.js')
<script src="assets/js/typeahead.js"></script>
<script src="assets/js/typeahead-autocomplete-company.js"></script>
@stop