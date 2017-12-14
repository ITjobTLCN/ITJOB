@extends('layouts.master')
@section('title')
Application
@endsection
@section('body.content')
<div class="application-wrapper">
	<div class="application container">
		<div class="content">
			<div class="apply-header">
				<h3>
					<div class="ja-info">
						<span class="job-title">{{$job->name}}</span>
						at
						<span class="company">{{$employer}}</span>
					</div>
				</h3>
			</div>
			<div class="form-apply">
				<div class="row">

					<div class="form-content">
						
					<form class="form-horizontal" id="formApply" enctype="multipart/form-data" method="post" action="{{route('applyJob')}}">
						<div class="form-group">
							@if(Session::has('success'))
								<div class="modal fade" id="modal-id">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title">Modal title</h4>
											</div>
											<div class="modal-body">
												{{Session::get('success')}}
											</div>
										</div>
									</div>
								</div>
							@endif
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Your name:</label>
							<div class="col-sm-10">
								<input type="hidden" value="{{$job->id}}" name="job_id">
								<input type="text" value="{{$user->name}}" name="fullname" class="form-control" id="fullname" placeholder="Enter your full name">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Email:</label>
							<div class="col-sm-10">
								<input type="email" name="email" value="{{$user->email}}" class="form-control" id="email" placeholder="Enter email">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="pwd">Your CV:</label>
							<div class="col-sm-10">
								@if($user->cv !=null)
									<a href="uploads/user/cv/{{$user->cv}}" download>{{$user->cv}}</a>
								@endif
								<input type="file" class="form-control" name="new_cv" id="new_cv" placeholder="Select your CV...">
								<span>We accept .doc .docx and .pdf files up to 1MB</span>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-12">
								<span>What skills, work projects or achievements make you a strong candidate? (Recommended)</span>
								<textarea name="note" id="note" cols="10" rows="5" class="form-control" placeholder="Details and specific examples will make your application..."></textarea>
							</div>
						</div>
						{{csrf_field()}}
						<div class="form-group"> 
							<div class="col-sm-12">
								<button type="submit" class="btn btn-default send_now pull-right">Send</button>
							</div>
						</div>
					</form>
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