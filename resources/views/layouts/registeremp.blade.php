@extends('layouts.master')
@section('title')
Đăng ký nhà tuyển dụng | ITJob
@endsection
@section('body.content')
<div class="manager-account" ng-controller="HomeController" ng-init="loadReg()">
	<!-- content -->
	<div class="container">
		<div class="row main-content">
			<div class="title-profile text-center">
				<h2>Register a employer</h2>
			</div>
		</div>
		<div class="wrapper-profile">
			<div class="box box-md">
				<div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
					<form action="#" method="POST" id="register_emp_form">
						<input type="hidden" name="empid" ng-model="curemp.empid" value="<%curemp.id%>">
						<div class="form-group">

							<label for="">Choose one:</label>
							<div class="row">
								<div class="col-md-8">
									<select ng-model="curemp" id="curemp" ng-options="emp.name for emp in emps track by emp._id" class="form-control" ng-change="new=false"></select>
								</div>
								<div class="col-md-4">
									<button type="button" class="btn btn-google btn-sm" ng-click="reset()">Reset</button>
								</div>
							</div>
							<!-- <%curemp%> -->
						</div>
						<div class="form-group">
							<label for="name" >Employer Name:</label>
							<input type="text" name="name"  class="form-control" placeholder="Employer name" ng-readonly="!new" ng-model="curemp.name">
						</div>
						<div class="form-group">
							<label for="">City</label>
							<select name="city_id" id="city_id" class="form-control" ng-options="item._id as item.name for item in cities" ng-readonly="!new" ng-model="curemp.city_id"></select>
						</div>
						<div class="form-group">
							<label for="address">Address</label>
							<input type="text" name="address" class="form-control" placeholder="Address" ng-readonly="!new" ng-model="curemp.address[0]['detail']">
						</div>
						<div class="form-group">
							<label for="website">Employer Website</label>
							<input type="text" name="website" class="form-control" placeholder="Link website" ng-readonly="!new" ng-model="curemp.website">
						</div>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="form-group">
							<div class="text-center" style="float: right">
								<button type="button" ng-click="submitReg()" class="btn btn-facebook">Send Request</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('footer.js')
<script src="assets/angularjs/controller/HomeController.js"></script>
@endsection