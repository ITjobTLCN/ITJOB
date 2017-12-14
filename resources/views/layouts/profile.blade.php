@extends('layouts.master')
@section('title')
Thông tin cá nhân | ITJob
@stop
@section('body.content')
<div class="manager-account" ng-controller="UsersController">
	<div class="container ">
		<div class="row"></div>
		<div class="row main-content">
			<div class="title-profile text-center">
				<h2>Manage your profile settings</h2>
			</div>
			@if(Auth::check())
			<div class="wrapper-profile">
				<div class="box box-md">

					<div class="col-md-2 col-sm-3">
						
						<div class="avatar_profile">
							@if($user->password !="")
							<img src="uploads/avatar/{{$user->image}}" alt="" class="img-responsive" width="150px" height="150px">
							@else
							<img src="{{$user->image}}" alt="" class="img-responsive" width="150px" height="150px">
							@endif
								

						</div>
						<form enctype="multipart/form-data" action="{{route('postAvatar')}}" method="post">
									<input type="file" name="avatar">
									{{csrf_field()}}
									<input type="submit" value="Upload" class="btn btn-sm btn-primary">

								</form>
					</div>
					<div class="col-md-7 col-sm-9">
						@if(Session::has('success'))
						<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    {{Session::get('success')}}
  </div>
					@endif
						<div class="welcome">
							<h3> Welcome, {{$user->name}}
							</h3>
						</div>
						<div class="info">
							<form class="form-horizontal" name="frmEditProfile" id="myForm" enctype="multipart/form-data" method="post" action="{{route('editProfile')}}" role="form" >
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
									<div class="col-sm-6">
										<input name="email" class="form-control" disabled="true" class="email" value="{{$user->email}}">
									</div>
									<div class="col-sm-2 col-xs-2">
										<div class="checkbox">
											<label>
												<input type="checkbox" ng-model="showEmail"> Change
											</label>
										</div>
									</div>
								</div>
								<div class="form-group" ng-show="showEmail">
									<label for="inputEmail3" class="col-sm-2 hidden-xs control-label"></label>
									<div class="col-sm-8">
										<input type="email" class="form-control" value="{{$user->email}}" name="newemail" id="newEmail" required="true"> 
										<div id="error">
											<span style="color:red" ng-cloak ng-show="(frmEditProfile.newEmail.$dirty && frmEditProfile.newEmail.$invalid)">
												<span ng-show="frmEditProfile.newEmail.$error.required">Không được để trống</span>
												<span ng-show="frmEditProfile.newEmail.$error.email">Nhập đúng định dạng</span>
											</span>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
								<div class="form-group" ng-show="showEmail">
									<div class="col-sm-offset-2 col-sm-8">
										<button type="submit" ng-disabled="newEmail.$valid || newEmail.$dirty" class="btn btn-danger" ng-click="saveNewEmail()">Save New Email</button>
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-6">
										<input type="text" name="name" value="{{$user->name}}" class="form-control" id="inputPassword3">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-2 control-label">Description</label>
									<div class="col-sm-10">
										<textarea type="text" name="describe" class="form-control" id="inputPassword3" style="height: 100px">{{$user->describe}}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-2 control-label">CV</label>
									<div class="col-sm-8">
										@if($user->cv !=null)
										<a href="uploads/cv/{{$user->cv}}" download>{{$user->cv}}</a>
										@endif
										<input type="file" value="{{$user->cv}}" class="form-control" name="cv" id="cv"">
										<span>We accept .doc .docx and .pdf files up to 1MB</span>
									</div>
								</div>
								{{csrf_field()}}
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-danger">Save Changes</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			@else
			<h2 class="text-center">Please login before using this function</h2>
			@endif
		</div>
		
		<div class="clearfix"></div>
	</div>
	
</div>	
@stop
@section('footer.js')
<script src="assets/controller/UsersController.js"></script>
<script src="assets/JQuery/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
// just for the demos, avoids form submit
$( "#myForm" ).validate({
  rules: {
    cv: {
      extension: "pdf|doc|docx"
    }
  },
  messages:{
  	cv:{
  		extension: "Vui lòng đính kèm file .doc .docx hoặc .pdf"
  	}
  }
});
</script>
@stop