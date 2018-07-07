@extends('layouts.master')
@section('title')
Thông tin cá nhân | ITJob
@stop
@section('body.content')
<div class="manager-account" ng-controller="UsersController">
	<div class="container" ng-init="init()"">
		<div class="row"></div>
		<div class="row main-content">
			<div class="title-profile text-center">
				<h2>Manage your profile settings</h2>
			</div>
			<div class="wrapper-profile">
				<div class="box box-md">
					<div class="col-md-6 col-sm-3">

						@if(!empty($user->password))
						<img src="uploads/avatar/{{$user->avatar}}" alt="" class="img-responsive" style="border-radius: 100%; width: 150px;height: 150px; float: left;margin-right: 20px">
						@else
						<img src="{{$user->image}}" alt="" class="img-responsive"
						style="border-radius: 100%; width: 150px;height: 150px; float: left; margin-right: 20px">
						@endif
						<h3> Welcome, <% fullname %>
						</h3>
						<form enctype="multipart/form-data" action="{{route('postAvatar')}}" method="post">
							<label for="file" class="upload-file"><i class="fa fa-upload"> Choose a file</i></label>
							<input type="file" name="avatar" id="file"><br>
							{{csrf_field()}}
							<input type="submit" value="Upload" class="btn btn-sm btn-facebook">

						</form>
					</div>
					<div class="col-md-6 col-sm-9">
						@if(Session::has('success'))
						<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							{{Session::get('success')}}
						</div>
						@endif
						<div class="info">
							<form class="form-horizontal" name="frmEditProfile" id="myForm" enctype="multipart/form-data" method="post" action="{{route('editProfile')}}" role="form" >
								<div class="form-group">
									<label for="inputEmail" class="col-sm-2 control-label">Email</label>
									<div class="col-sm-6">
										<input name="email" class="form-control" disabled="true" class="email" ng-model="user.email">
									</div>
									<div class="col-sm-2 col-xs-2">
										<div class="checkbox">
											<label>
												<input type="checkbox" ng-click="changeEmail()"> Change
											</label>
										</div>
									</div>
								</div>
								<div class="form-group" ng-if="hasChangeEmail">
									<label for="inputNewEmail" class="col-sm-2 hidden-xs control-label"></label>
									<div class="col-sm-8">
										<input type="email" class="form-control" ng-model="user.email" name="newemail" id="newEmail">
										<div class="clearfix"></div>
									</div>
								</div>
								<div class="form-group" ng-if="hasChangeEmail">
									<div class="col-sm-offset-2 col-sm-8">
										<button ng-click="saveNewEmail()" type="button" class="btn btn-google">Save New Email</button>
									</div>
								</div>
								<div class="form-group">
									<label for="inputName" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-6">
										<input type="text" name="name" ng-model="user.name" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="inputDescription" class="col-sm-2 control-label">Description</label>
									<div class="col-sm-10">
										<textarea type="text" name="description" class="form-control" style="height: 100px"><% user.description %></textarea>
									</div>
								</div>
								<div class="form-group" ng-if="['5ac85f51b9068c2384007d9c'].indexOf(user.role_id) != -1">
									<label for="inputCV" class="col-sm-2 control-label">CV</label>
									<div class="col-sm-8">
										<span ng-if="user.hasOwnProperty('cv')">
											<a ng-href="<% viewCV(user.cv) %>" target="_blank"><% user.cv %></a>
										</span>
										<input type="file" ng-model="user.cv" class="form-control" name="cv" id="cv"">
										<span>We accept .doc .docx and .pdf files up to 1MB</span>
									</div>
								</div>
								{{csrf_field()}}
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-google">Save Changes</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
@stop
@section('footer.js')
<script src="assets/controller/UsersController.js"></script>
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