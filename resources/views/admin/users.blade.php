@extends('admin.layout.new_master')
@section('primary-title') Accounts Management @endsection
@section('secondary-title') List users @endsection
@section('content')
<div ng-controller="UsersController">
	<div class="box">
		<div class="box-body">
			<div class="datatable-above">
				<span>Show:</span>
				<select class="form-control show-entries" ng-model="showitems">
					<option value="3" ng-selected="showitems == 3">3</option>
					<option value="5" ng-selected="showitems == 5">5</option>
					<option value="10" ng-selected="showitems == 10">10</option>
					<option value="20" ng-selected="showitems == 20">20</option>
				</select>
				<span>entries</span>
				<a href="javascript:void(0)" class="btn btn-flat btn-primary btn-add-new" ng-click="modal(constant.MODAL_ADD)">New</a>
				<div class="input-group datatable-search">
					<span class="input-group-addon"><i class="fa fa-search"></i></span>
					<input type="text" class="form-control " placeholder="Search..." ng-model="searchUser">
				</div>
			</div>

			<table class="table table-responsive table-hover table-bordered">
				<thead class="thead-inverse">
					<tr class="info">
						<th ng-click="sort('email')" style="width: 30%">Email
							<span class="glyphicon sort-icon" ng-show="sortType=='email'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" ></span>
						</th>
						<th ng-click="sort('name')" style="width: 15%">Name
							<span class="glyphicon sort-icon" ng-show="sortType=='name'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" >
						</th>
						<th ng-click="sort('roles.name')">Role
							<span class="glyphicon sort-icon" ng-show="sortType=='roles.name'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" >
						</th>
						<th ng-click="sort('created_at')" style="width: 20%">Created At
							<span class="glyphicon sort-icon" ng-show="sortType=='created_at'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" >
						</th>
						<th ng-click="sort('updated_at')" style="width: 20%">Updated At
							<span class="glyphicon sort-icon" ng-show="sortType=='updated_at'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" >
						</th>
						<th ng-click="sort('lastlogin')" style="width: 10%">Last Login
							<span class="glyphicon sort-icon" ng-show="sortType=='lastlogin'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" >
						</th>
					</tr>
				</thead>
				<tbody>
					<tr dir-paginate="item in users|orderBy:sortType:sortReverse|filter:searchUser|itemsPerPage:showitems">
						<td>
							<span><%item.email%></span>
							<div>
								<a href="javascript:void(0)" ng-click="modal(constant.MODAL_EDIT, item)">Edit </a>|
								<a href="javascript:void(0)" ng-click="delete(item._id)"> Delete</a>
							</div>
						</td>
						<td><%item.name%></td>
						<td><%item.roles.name%></td>
						<td><%item.created_at%></td>
						<td><%item.updated_at%></td>
						<td><%item.lastlogin%></td>
					</tr>

				</tbody>
			</table>
			<div class="text-center">
				<dir-pagination-controls
					max-size="5"
					direction-links="true"
					boundary-links="true"
					>
				</dir-pagination-controls>
			</div>
		</div>
	</div>

		<!-- Model create user  - one page  -->
	<div class="modal fade" id="modal-create-user">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">
						<i class="<% user_modal.class %>"></i> <%user_modal.title%>
					</h4>
				</div>
				<form action="#" method="post" name="frmCreate">
					<div class="modal-body">
						<div class="alert alert-danger" id="ng-errors-alert" style="display: none; color: red">
							<p id="ng-errors-message">
								<%error_message%>
							</p>
						</div>

						<div id="modallogin-logininfo">
							<div class="form-group row">
								<label for="email" class="control-label col-md-2 label-form-horizontal">Email: </label>
								<div class="col-md-10">
									<input type="email" ng-model="user.email" class="form-control" name="email" id="email" required="">
									<span class="errors" ng-show="(frmCreate.email.$dirty && frmCreate.email.$invalid)">
										<span ng-show="frmCreate.email.$error.email" style="color: red">Please enter a valid email address</span>
										<span ng-show="frmCreate.email.$error.required" style="color: red">Please enter a email</span>
									</span>
								</div>
							</div>
							<div ng-if="state =='edit'" style="margin-bottom: 10px; margin-left: 5px">
								<button type="button" id="btnchangepassword" class="btn btn-sm btn-warning col-md-offset-2" ng-click="toggleChange()">Change Password</button>
							</div>
							<div id="block-changepassword" ng-show="change">
								<div class="form-group row">
									<label for="password" class="control-label col-md-2 label-form-horizontal">Password: </label>
									<div class="col-md-10">
										<input type="password" ng-model="user.password" class="form-control" name="password" id="password" minlength="6">
										<span class="errors" ng-show="(frmCreate.password.$dirty && frmCreate.password.$invalid)">
											<span ng-show="frmCreate.password.$error.minlength" style="color: red">Password has at least 6 characters</span>
										</span>
									</div>
								</div>


								<div class="form-group row">
									<label for="repassword" class="control-label col-md-2 label-form-horizontal">Re-type Password: </label>
									<div class="col-md-10">
										<input type="password" ng-model="user.repassword" class="form-control" name="repassword" id="repassword" minlength="6">
										<span class="errors" ng-show="(frmCreate.repassword.$dirty && (frmCreate.repassword.$invalid || user.password!==user.repassword))">
											<span ng-show="frmCreate.repassword.$error.minlength">Re-type password has at least 6 characters</span>
											<span ng-show="user.password!=user.repassword" style="color: red">Confirm password not match</span>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div id="modallogin-userinfo">
							<div class="form-group row">
								<label for="name" class="control-label col-md-2 label-form-horizontal">Name: </label>
								<div class="col-md-10">
									<input type="text" class="form-control" ng-model="user.name" name="name" id="name" ng-required="true">
									<span class="errors" ng-show="(frmCreate.name.$dirty && frmCreate.name.$invalid)">
										<span ng-show="frmCreate.name.$error.required" style="color: red">Type a name</span>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="status" class="control-label col-md-2 label-form-horizontal">Status: </label>
								<div class="col-md-10">
									<select name="status" class="form-control" id="status" ng-model="user.status" required>
										<option value="1" ng-selected="user.status == 1">Active</option>
										<option value="0" ng-selected="user.status == 0">Non-active</option>
									</select>
									<span class="errors" ng-show="(frmCreate.status.$error.required)">
										Choose status
									</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="name" class="control-label col-md-2 label-form-horizontal">Role: </label>
								<div class="col-md-10">
									<select name="role_id" ng-model="user.role_id" class="form-control" id="role" ng-options="role._id as role.name for role in roles"
									    required>
									</select>
									<span class="errors" ng-show="(frmCreate.role_id.$error.required)">
										Choose role
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" ng-disabled="(frmCreate.$invalid || (user.password!==user.repassword))" ng-click="save()">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@section('script')
	<script src="assets/angularjs/controller/UsersController.js"></script>

	@endsection
</div>

@endsection
