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
											<a href=""><img title="" class="img-responsive" src="uploads/emp/logo/{{ $tjv->employer['images']['avatar'] }}" alt="">
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
												<h3>{{ $tjv->detail['description'] }}</h3>
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