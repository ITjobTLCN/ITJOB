@extends('companies.master')
@section('title')
{{$company->name}} | ITJob
@stop
@section('body.content')
<div class="detail-companies" ng-controller="CompanyController">
    <div class="container">
        <section class="home-companies">
            <div class="cover-photo_company" id="home">
                <img src="assets/img/episerver-headline-photo-compress.jpg" alt="" class="img-responsive">
            </div>
            <div class="profile-header_company">
                <div class="row">
                    <div class="col-md-2 col-sm-3 col-xs-12">
                        <div class="logo-company">
                            <img src="assets/img/episerver-logo-170-151.png" alt="" class="img-responsive">
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-5 col-xs-12">
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
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="action_companies">
                            <div class="add_review">
                                @if(Auth::check())
                                <a href="{{route('reviewCompany',$company->alias)}}" class="btn btn-danger">Add Review</a> @else
                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#loginModal">Add Review</a> @endif
                            </div>

                            @if(Auth::check())
                            <input type="hidden" value={{$company->id}} id="emp_id"> @if($follow)
                            <div class="followed">
                                <a class="btn btn-default" id="unfollowed">Following <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></a>
                            </div>
                            @else
                            <div class="followed">
                                <a class="btn btn-default">Follow ({{$company->follow}})<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></a>
                            </div>
                            @endif @else
                            <div class="followed" bs-popover>
                                <a class="btn btn-default" rel="popover">Follow ({{$company->follow}}) <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></a>

                            </div>

                        </div>
                        @include('partials.modal-login') @endif
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
                                    <div class="col-md-6 col-sm-6"><img src="assets/img/BIM_Group-Office-2.png" alt="">
                                    </div>
                                    <div class="col-md-6 col-sm-6"><img src="assets/img/BIM_Group-Office-3.png" alt="">
                                    </div>
                                    <div class="col-md-6 col-sm-6"><img src="assets/img/BIM_Group-Office-4.png" alt="">
                                    </div>
                                    <div class="col-md-6 col-sm-6"><img src="assets/img/BIM_Group-Office-2.png" alt="">
                                    </div>
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

                </div>

            </div>
            <!-- End row -->
        </section>
        <section class="rating-companies">
            <div id="ratings">
                <div class="header-section">
                    <h1>Ratings <span>(Có {{count($reviews)}} bài đánh giá)</span></h1>
                    <span class="under-line"></span>
                </div>
                <div class="row main-rating">
                    <div class="col-md-8" id="list-review">
                        <div class="panel panel-default">
                            <div class="panel-body ">
                            	<div class="result-reviews">
                            		@foreach($reviews as $rv)
                                <div class="content-of-review">
                                    <div class="short-summary">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="short-title">{{$rv->title}}</h3>
                                                <div class="stars-and-recommend">
                                                    <span class="rating-stars-box">
                                                    	@for($i=0;$i < $rv->rating;$i++)
														<a href="" ><i class="fa fa-star" aria-hidden="true"></i></a>
														@endfor
													</span>
													@if($rv->recommend==1)
                                                    <span class="recommend"><i class="fa fa-thumbs-o-up"></i> Recommend</span>
                                                    @else
													<span class="recommend"><i class="fa fa-thumbs-o-down"></i>UnRecommend</span>
                                                    @endif
                                                </div>
                                                <div class="date">{{$rv->created_at->format('d-M Y')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="details-review">
                                        <div class="what-you-liked">
                                            <h3>Điều tôi thích</h3>
                                            <div class="content paragraph">
                                                <p>{{$rv->like}}</p>
                                            </div>
                                        </div>
                                        <div class="feedback">
                                            <h3>Đề nghị cải thiện</h3>
                                            <div class="content paragraph">
                                                <p>{{$rv->suggests}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            	</div>
                                <div class="load-more">
                                    <a href="" id="see-more__reviews">See more...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="avg-review">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="panel-body disable-user-select">
                                    <span class="rating-stars-box">
										<div class="star-review">
											<a href="" ><i class="fa fa-star" aria-hidden="true"></i></a>
											<a href="" ><i class="fa fa-star" aria-hidden="true"></i></a>
											<a href="" ><i class="fa fa-star" aria-hidden="true"></i></a>
											<a href="" ><i class="fa fa-star" aria-hidden="true"></i></a>
										</div>
									</span>
                                    <span class="company-ratings__star-point">{{number_format($company->rating,1)}}</span>
                                    <hr class="divider">
                                    <table class="company-rating-info__chart-recommend clearfix">
                                        <tbody>
                                            <tr>
                                                <td class="chart" data-percent="90">
                                                </td>
                                                <td class="recommend">Recommend working here to a friend</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr class="divider">
                                    <div class="view-more">
                                        <a href="/companies/kms-technology/review">See all ratings and reviews</a>
                                        <i class="fa fa-caret-right"></i>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="hiring-now-companies">
            <div id="hiring-now">
                <div class="header-section">
                    <h1>Hiring Now</h1>
                    <span class="under-line"></span>
                </div>
                <div class="list-job-hiring">
                    <input type="hidden" value="{{$company->id}}" id="company_id"> {{--
                    <p id="show-jobs">click me</p> --}}
                    <div class="title">
                        <a data-toggle="collapse" id="up-down" href="#list-job-content">{{$jobs}} Jobs waiting for you <span><i class="fa fa-arrow-down" aria-hidden="true"></i></span></a>
                    </div>
                    <div id="list-job-content" class="panel-collapse collapse">
                        <div class="result-job-company"></div>
                        <div class="loading text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
                        <div class="load-more">
                            <a href="" id="see-more-job-company">See more</a>
                        </div>
                    </div>
                    <div id="result-jobs"></div>
                </div>
            </div>
            <!-- End row -->
            @include('partials.modal-login')
        </section>
    </div>
</div>
@stop
@section('footer.js')
<script src="assets/js/jquery.circlechart.js"></script>
<script src="assets/js/detail-companies.js"></script>
<script src="assets/controller/SkillsController.js"></script>
<script src="assets/controller/CompanyController.js"></script>
@stop