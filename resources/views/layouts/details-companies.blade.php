@extends('companies.master')
@section('title')
{{$company->name}} | ITJob
@endsection
@section('body.content')
<div class="detail-companies" ng-controller="CompanyController">
    <div class="container">
        <section class="home-companies">
            <div class="cover-photo_company" id="home">
                <img src="uploads/emp/cover/{{$company->images['cover']}}" alt="" class="img-responsive">
            </div>
            <div class="profile-header_company">
                <div class="row">
                    <div class="col-md-2 col-sm-3 col-xs-12">
                        <div class="logo-company">
                            <img src="uploads/emp/logo/{{$company->images['avatar']}}" alt="" class="img-responsive">
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-9 col-xs-12">
                        <div class="name-info">
                            <h2 id="name-company">{{$company->name}}</h2>
                            <div class="location">
                                @foreach($company->address as $val)
                                <i class="fa fa-location-arrow" aria-hidden="true"></i> {{$val['detail']}} <br>
                                @endforeach
                            </div>
                            <div class="num-employee">
                                <span data-toggle="tooltip" title="Personel"><i class="fa fa-users" aria-hidden="true"></i> 100-200</span>
                            </div>
                            <div class="see-maps">
                                <a href=""><i class="fa fa-map" aria-hidden="true"></i> See on map</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="action_companies">
                            <div class="add_review">
                                @if(Auth::check())
                                <a href="{{route('reviewCompany', $company->alias)}}" class="btn btn-danger">Add Review</a> 
                                @else
                                <a class="btn btn-danger" id="openLoginModal">Add Review</a> 
                                @endif
                            </div>

                            @if(Auth::check())
                                <input type="hidden" value={{$company->_id}} id="emp_id"> 
                                <div class="followed">
                                    @if($follow)
                                        <a class="btn btn-default" id="unfollowed">Following <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></a>
                                    @else
                                        <a class="btn btn-default">Follow ({{$company->quantity_user_follow}})<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></a>
                                    @endif 
                                </div>
                            @else
                            <a class="btn btn-default" id="openLoginModal">Follow ({{$company->quantity_user_follow}})</a>
                        </div>
                        @endif
                        @include('partials.modal-login')
                        @include('partials.modal-register')
                    </div>
                </div>
            </div>
        </section>
        <section class="reviews-companies">
            <div id="reviews">
                <div class="header-section">
                    <p>About Us</p>
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
                    @if(count($skills)!=0)
                    <div id="skills">
                        <h2 class="title">All Our Tag Skills</h2>
                        <ul>
                            @foreach($skills as $skill)
                            <li class="employer-skills__item">
                                <a href="{{route('quickJobBySkill', $skill->alias)}}" target="_blank">{{$skill->name}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

            </div>
            <!-- End row -->
        </section>
        <section class="rating-companies">
            <div id="ratings">
                
                <div class="header-section">
                    @if(count($reviews)!=0)
                    <p>Ratings <span>(Có {{count($reviews)}} bài đánh giá)</span></p>
                    
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
                                                    	@for($i = 0; $i < $rv->rating; $i++)
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
                                <div class="loading text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
                                <div class="load-more">
                                    @if(Auth::check())
                                    <a href="" id="see-more__reviews">See more...</a>
                                    @else
                                    <a href="" id="openLoginModal">See more...</a> @endif
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
											@for($i = 0; $i < $company->rating; $i++)
                                             <a href="" ><i class="fa fa-star" aria-hidden="true"></i></a>
                                            @endfor
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
                                        <a href="#">See all ratings and reviews</a>
                                        <i class="fa fa-caret-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <p>Ratings <span>(Có 0 bài đánh giá)</span></p>
                @endif
            </div>
        </section>
        <section class="hiring-now-companies">
            <div id="hiring-now">
                <div class="header-section">
                    <p>Hiring Now</p>
                    <span class="under-line"></span>
                </div>
                <div class="list-job-hiring">
                    <input type="hidden" value="{{$company->_id}}" id="company_id" name="company_id"> 
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
            
        </section>
    </div>
</div>
@endsection
@section('footer.js')
<script src="assets/js/jquery.circlechart.js"></script>
<script src="assets/js/detail-companies.js"></script>
<script src="assets/js/validate-form.js"></script>
<script src="assets/controller/SkillsController.js"></script>
<script src="assets/controller/CompanyController.js"></script>
@endsection