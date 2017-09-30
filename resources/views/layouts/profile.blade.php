@extends('layouts.master')
@section('title')
Thông tin cá nhân
@stop
@section('body.content')
<div class="wrapper">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="{{route('/')}}">Home</a></li>
			<li class="active">Profile</li>
		</ol>
	</div>
	<div class="title-profile text-center">
		<h2>Manage your profile settings</h2>
	</div>
	<div class="row wrapper-profile">
		@if(Auth::check())
		<div class="col-md-4">

			<div class="avatar_profile">
				<img src="assets/img/avatar_profile.jpg" alt="">
			</div>
		</div>
		<div class="col-md-8 manage-profile">
			<div class="welcome">
				<h3> Welcome, {{Auth::user()->name}}
				</h3>
			</div>
			<div class="info">
				<form class="form-horizontal" name="frmEditProfile" role="form" ng-submit="login()" ng-controller="UsersController">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 hidden-xs control-label">Email</label>
						<div class="col-sm-8 col-xs-8">
							<input type="email" class="form-control" ng-model="email" id="inputEmail3" disabled="true" 
							ng-init="email='{{Auth::user()->email}}'"> 
						</div>
						<div class="col-sm-2 col-xs-4">
							<div class="checkbox">
						        <label>
						          <input type="checkbox" ng-model="showEmail"> Change
						        </label>
						      </div>
						</div>
					</div>
					<div class="form-group" ng-show="showEmail">
						<label for="inputEmail3" class="col-sm-2 hidden-xs control-label"></label>
						<div class="col-sm-8 col-xs-8">
							<input type="hidden" class="form-control" ng-init="id='{{Auth::user()->id}}'" name="id" ng-model="id">
							<input type="email" class="form-control" ng-model="newEmail"  name="newEmail" id="inputEmail3" ng-init="newEmail='{{Auth::user()->email}}'" required="true"> 
							 <div id="error">
							 	<span style="color:red" ng-cloak ng-show="(frmEditProfile.newEmail.$dirty && frmEditProfile.newEmail.$invalid)">
							 	<span ng-show="frmEditProfile.newEmail.$error.required">This field is required.</span>
							 	<span ng-show="frmEditProfile.newEmail.$error.email">Please enter a valid email address.</span>
							 </span>
							 </div>
							 <div class="clearfix"></div>
						</div>
					</div>
					<div class="form-group" ng-show="showEmail">
						<div class="col-sm-offset-2 col-sm-8">
							<button type="submit" class="btn btn-danger" ng-disabled="frmEditProfile.$invalid" ng-click="saveNewEmail()" style="float: right">Save New Email</button>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-8">
							<input type="text" name="name" class="form-control" ng-model="name" id="inputPassword3" ng-init="name='{{Auth::user()->name}}'">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<textarea type="text" name="desc" ng-init="desc='{{Auth::user()->describe}}'" ng-model="desc" class="form-control" id="inputPassword3" style="height: 100px">
							</textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">CV</label>
						<div class="col-sm-8">
							<input type="file" class="form-control" name="CV" id="inputPassword3"">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-danger" ng-click="saveProfile()">Save Changes</button>
						</div>
					</div>
				</form>
			</div>
			@else
			<h2 class="text-center">Please login before using this function</h2>
			@endif
		</div>
	</div>
</div>
@stop
@section('footer.js')
<script src="assets/controller/UsersController.js"></script>
@stop