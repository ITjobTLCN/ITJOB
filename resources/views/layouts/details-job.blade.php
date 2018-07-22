@extends('layouts.master')
@section('title') {{ $job['name'] }} at {{ $job->employer['name'] }}
@endsection
@section('body.content')
<div class="job-details" ng-controller="SkillsController">
    <section class="main-content container">
        <div class="job-header">
            <div class="job-header__list-photo hidden-xs">
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
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pull-left">
                    <div class="image-employer">
                        <div class="box box-md">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="job-header__info">
                                                <h1 class="job-title">
                                                    {{ $job['name'] }}
                                                </h1>
                                                <span class="company-name text-lg"><strong>{{ $job->employer['name'] }}</strong></span>
                                                <div class="block">
                                                    <span title="Address"><i class="fa fa-home" aria-hidden="true"></i></span>
                                                    @foreach($job->employer['address'] ?? [] as $val)
                                                        <span class="employer_address">{{ $val['detail'] }}</span>
                                                    @endforeach
                                                </div>
                                                <div class="block">
                                                    <span title="Address"><i class="fa fa-cog" aria-hidden="true"></i></span>
                                                    <span class="employer_address"><strong>Product</strong></span>
                                                </div>
                                                <div class="block">
                                                    <span title="Location"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                                    <span class="employer-location"> {{ $job['city'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row row-salary">
                                            <span class="tag-salary">Salary: <strong class="">
        										@if(Auth::check()) {{ $job->detail['salary'] }}
        										@else <a href="" data-toggle="modal" data-target="#loginModal">Login to see salary</a>
        										@endif
        									</strong>
        									</span>
                                        </div>
                                        <div class="row">
                                            <div ng-init="listSkillJob('{{ $job['_id'] }}')">
                                                <span class="tag-skill" title="<% skill.name %>" ng-repeat="skill in skillsjob"><% skill.name %></span>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!Auth::check() || Auth::user()->role_id == '5ac85f51b9068c2384007d9c')
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="action-apply">
                                                <a href="{{route('getApplyJob', [$job['alias'], $job['_id']])}}" class="btn btn-primary btn-xlg col-xs-12">Apply Now</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Job Detail --}}
                    <div id="job-detail">
                        <div class="box box-md">
                            {{-- Job Description --}}
                            <h2>The Job</h2>
                            <div id="job-description" class="job-info">
                                {!!$job['detail']['description']!!}
                            </div>
                            {{-- Job Requirement --}}
                            <h2>Your Skills and Experience</h2>
                            <div id="job-requirement" class="job-info">
                                {{ $job['policy']['required'] }}
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
                                            </div>
                                        </div>
                                        {{ $job['policy']['treatment'] }}
                                    </div>
                                </div>
                            </div>
                            <h2>Technologies We're using</h2>
                            <div id="Technology">
                                <div ng-init="listSkillCompanies('{{ $job['employer_id'] }}')">
                                    <span class="tag-skill" title="<% skill.name %>" ng-repeat="skill in skillsemp"><% skill.name %></span>
                                </div>
                            </div>
                            @if(!Auth::check() || Auth::user()->role_id == '5ac85f51b9068c2384007d9c')
                            <a href="{{route('getApplyJob',[$job['alias'], $job['_id']])}}" class="btn btn-primary btn-xlg col-xs-12 apply" type="button">Apply Now</a>
                            @endif
                        </div>
                    </div>
                    @if(!Auth::check() || Auth::user()->role_id == '5ac85f51b9068c2384007d9c')
                    <div id="jobs-most-viewer">
                        <div class="box box-md">
                            <h2>Top Jobs For You</h2>
                            <div id="top-job-viewer">
                                <table class="table table-hover">
                                    <tbody>
                                        @foreach($topJobViewer as $tjv)
                                        <tr>
                                            <td>
                                                <div class="job-item">
                                                    <div class="row" >
                                                        <div class="col-xs-12 col-sm-2 col-md-3 col-lg-2" >
                                                            <div class="logo job-search__logo">
                                                                <a href=""><img title="" class="img-responsive" src="uploads/emp/avatar/{{ $tjv->employer['images']['avatar'] }}" alt="">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="job-item-info" >
                                                                <h3 class="bold-red">
                                                                    <a href="" class="job-title" target="_blank">{{ $tjv->name }}</a>
                                                                </h3>
                                                                <div class="company">
                                                                    <span class="job-search__company">{{ $tjv->employer['name'] }}</span>
                                                                    <span class="separator">|</span>
                                                                    <span class="job-search__location">{{ $tjv->city }}</span>
                                                                </div>
                                                                <div class="description-job">
                                                                    <h3>{!! $tjv->detail['description'] !!}</h3>
                                                                </div>
                                                                <div class="company text-clip">
                                                                    <span class="salary-job">
                                                                        @if(Auth::check())
                                                                        {{ $tjv->detail['salary'] }} $
                                                                        @else
                                                                        <a href="" data-toggle="modal" data-target="#loginModal">Đăng nhập để xem lương</a>
                                                                        @endif
                                                                    </span>
                                                                    <span class="separator">|</span>
                                                                    <span class="">{{ date('d-m-Y', strtotime($tjv->created_at)) }}</span>
                                                                </div>
                                                                <div style="margin-top: 10px;">
                                                                    @foreach(app(App\Http\Controllers\JobsController::class)->getListSkillJobv($tjv->skills_id) as $sj)
                                                                    <span class="tag-skill" title="{{ $sj->name }}">{{ $sj->name }}</span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-right">
                    <div class="box">
                        <div class="col-md-12 col-sm-12 employer-logo">
                            <div class="responsive-container box-limit">
                                <a href="{{route('getEmployers', $job->employer['alias'])}}" target="_blank" title="{{ $job->employer['name'] }}"><img src="uploads/emp/avatar/{{ $job->employer['images']['avatar'] }}" alt="" style="width: 150px; height: 150px"></a>

                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 employer-info">
                            <h3 class="name">{{ $job->employer['name'] }}</h3>
                            <div class="basic-info">
                                <div class="short">{{ $job->employer['info']['description'] }}</div>
                                @foreach($job->employer['address'] ?? [] as $key => $value)
                                    <p><i class="fa fa-home" aria-hidden="true"></i> Chi nhánh {{ $key + 1}}: {{ $value['detail'] }}</p>
                                @endforeach
                                <p><i class="fa fa-cog" aria-hidden="true"></i>Product</p>
                            </div>
                            <div class="more_job">
                                <div class="current-job">
                                    <a href="{{route('getEmployers',$job->employer['alias'])}}" target="_blank">
        								<i class="fa fa-arrow-right"></i> More job from this employer
        							</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box related-jobs">
                        <div class="header-top">
                            <a href="">Related job</a>
                        </div>
                        <div class="wrap">
                            <ul class="job">
                                @foreach($relatedJob as $rl)
                                <li class="item-job">
                                    <a href="{{route('detailjob', [$rl->alias, $rl->_id])}}" title="{{ $rl->name}}">
                                        <div class="title-job">{{ $rl->name}}</div>
                                        <div>
                                            <span class="company">{{ $rl->employer['name'] }}</span>
                                            <span class="location"><i class="fa fa-map-marker"></i> {{ $rl->city}}</span>
                                        </div>
                                        <div>
                                            <span class="salary"><i class="fa fa-wifi" aria-hidden="true"></i> @if(Auth::check()){{ $rl->detail['salary'] }}
												@else
												<a href="" data-toggle="modal" data-target="#loginModal">Login to see salary</a>
												@endif
											</span>
                                        </div>
                                        <div>
                                            @foreach (app(App\Http\Controllers\JobsController::class)->getListSkillJobv($rl->_id) as $key => $s)
                                            <a href=""><span class="tag-skill">{{ $s->name}}</span></a>
                                            @endforeach
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @include('partials.modal-login') @include('partials.modal-register')
                </div>
            </div>
        </div>
    </section>
</div>
@endsection @section('footer.js')
<script src="assets/js/modal-image-gallery.js"></script>
<script src="assets/js/validate-form.js"></script>
@endsection
