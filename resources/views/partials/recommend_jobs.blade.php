<div id="job-list" class="jb-search__result">
	@foreach($listJobLastest as $ljlt)
	<div class="job-item">
		<div class="row" >
			<div class="col-xs-12 col-sm-2 col-md-3 col-lg-2" >
				<div class="logo job-search__logo jb-search__result">
					<a href=""><img title="" class="img-responsive" src="uploads/emp/logo/{{$ljlt->le}}" alt="">
					</a>
				</div>
			</div>
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="job-item-info" >
					<h3 class="bold-red">
						<a href="{{route('detailjob',[$ljlt->alias, $ljlt->_id])}}" class="job-title" target="_blank">{{$ljlt->name}}</a>
					</h3>
					<div class="company">
						<span class="job-search__company">{{$ljlt['employer']['name']}}</span>
						<span class="separator">|</span>
						<span class="job-search__location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{$ljlt->city}}</span>
					</div>
					<div class="company text-clip">
						<span class="salary-job">
							@if(Auth::check())
							{{$ljlt->salary}}
							@else
							<a href="" data-toggle="modal" data-target="#loginModal">Đăng nhập để xem lương</a>
							@endif
						</span>
						<span class="separator">|</span>
						<span class="">@if(date('d-m-Y') == date('d-m-Y', strtotime($ljlt->created_at))) Today @else {{date('d-m-Y', strtotime($ljlt->created_at))}}@endif</span>
					</div>
					<div class="job__skill">
						@foreach (app(App\Http\Controllers\JobsController::class)->getListSkillJobv($ljlt->id) as $key => $s)
						<a href=""><span>{{$s->name}}</span></a>
						@endforeach
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-1 col-lg-2">
				@if(Auth::check())
				<div class="follow{{$ljlt->id}}" id="followJob" emp_id="{{$ljlt->emp_id}}" job_id="{{$ljlt->id}}">
					@if(app(App\Http\Controllers\JobsController::class)->getJobFollowed($ljlt->id)==1)
					<i class="fa fa-heart" aria-hidden="true" title="UnFollow"></i>
					@else
					<i class="fa fa-heart-o" aria-hidden="true" title="Follow"></i>
					@endif
				</div>
				@else
				<i class="fa fa-heart-o" aria-hidden="true" id="openLoginModal" title="Login to follow"></i>
				@endif
			</div>
		</div>	
	</div>
	@endforeach
	@if(count($listJobLastest) > 20)
	<button id="show-more-jobs" ng-click="showMoreJob()">Show more...</button>
	@endif
</div>