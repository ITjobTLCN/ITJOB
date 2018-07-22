@extends('layouts.master')
@section('title')
Application
@endsection
@section('body.content')
<div class="application-wrapper">
	<div class="application container">
		<div class="row">
			<div class="content col-md-8">
				<div class="apply-header">
					<div class="ja-info">
						<span class="job-title">Bạn đang ứng tuyển cho vị trí <strong>{{$job->name}}</strong></span>
						tại
						<strong class="company">{{$employer->name}}</strong>
					</div>
				</div>
				<div class="wrapper-form-apply">
					<div class="form-apply">
						<form id="formApply" enctype="multipart/form-data" method="post" action="{{route('applyJob')}}">
							<div class="form-group">
								@if(session('message'))
									<div class="alert alert-success alert-dismissable">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
											{{session('message')}}
										</div>
									@endif
									@if(Session::has('hasApply'))
										<span class="label label-danger" style="font-size: 15px">{{Session::get('hasApply')}}</span>
									@endif
							</div>
							<div class="form-group">
								<label class="inputName" for="email">Your name:</label>
								<input type="hidden" value="{{$job->id}}" name="job_id">
									<input type="text" value="{{$user->name}}" name="fullname" class="form-control" id="fullname" placeholder="Enter your full name">
							</div>
							<div class="form-group">
								<label class="inputEmail" for="email">Email:</label>
								<input type="email" name="email" value="{{$user->email}}" class="form-control" id="email" placeholder="Enter email">
							</div>
							<div class="form-group">
								<label class="inputCV" for="pwd">Your CV:</label>
								@if($user->cv != null)
										<a href="uploads/user/cv/{{$user->cv}}" download>{{$user->cv}}</a>
									@endif
									<input type="file" class="form-control" name="new_cv" id="new_cv" placeholder="Select your CV...">
									<span>We accept .doc .docx and .pdf files up to 1MB</span>
							</div>
							<div class="form-group">
								<span>What skills, work projects or achievements make you a strong candidate? (Recommended)</span>
									<textarea name="note" id="note" cols="10" rows="5" class="form-control" placeholder="Details and specific examples will make your application..."></textarea>
							</div>
							{{csrf_field()}}
							<button type="submit" class="btn btn-default send_now">Send</button>
						</form>
					</div>
				</div>
			</div>
			<div class="top-jobs col-md-4 hidden-sm">
				<span class="title">
					Top Job
				</span>
				<div class="content related-jobs">
					<div class="wrap">
	                    <ul class="jobs">
	                        @foreach($topJob as $job)
	                            <li class="item-job">
	                                <a href="{{route('detailjob', [$job->alias, $job->_id])}}" title="{{$job->name}}">
	                                    <div class="title-job">{{$job->name}}</div>
	                                    <div>
	                                        <span class="company">{{$employer->name}}</span>
	                                        <span class="location"><i class="fa fa-map-marker"></i> {{$job->city}}</span>
	                                    </div>
	                                    <div>
	                                        <span class="salary"><i class="fa fa-wifi" aria-hidden="true"></i>
	                                        	@if(Auth::check()){{$job->detail['salary']}} $
												@else
												<a href="" data-toggle="modal" data-target="#loginModal" style="font-size: 13px">Đăng nhập để xem lương</a>
												@endif
											</span>
	                                    </div>
	                                    <div>
	                                        	<span class="tag-skill">C++</span>
	                                    </div>
	                                </a>
	                            </li>
	                        @endforeach
	                    </ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('footer.js')
<script src="assets/js/validate-form.js"></script>
@endsection
