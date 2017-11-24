@extends('admin.layout.master')
@section('content')
	<div class="container" ng-controller="UsersController">
		<div class="row">
			<div class="col">
				<div  class="title-admin">Manage</div>
				<div>
					<span  class="table-title-admin">Administrator Account</span>
					<div class="btn-create-admin" >
						<label class="label-show-items">
							<span>Show:</span> 
							<select class="form-control input-sm"  ng-model="showitems">
								<option value="3" ng-selected="showitems==3">3</option>
								<option value="5" ng-selected="showitems==5">5</option>
								<option value="10" ng-selected="showitems==10">10</option>
								<option value="20" ng-selected="showitems==20">20</option>
							</select>
						</label>
						<div class="input-group table-input-search">
							<span class="input-group-addon"><i class="fa fa-search"></i></span>
        					<input type="text" class="form-control " placeholder="Search..." ng-model="searchUser">
						</div>
						<a href="javascript:void(0)" class="btn btn-outline btn-success btn-sm table-input-create" ng-click="modal('add')">Create account</a>
						
					</div>
				</div>		
				
				<table class="table table-responsive table-hover table-bordered table-angular">
					<thead class="thead-inverse">
						<tr class="info">
							<th ng-click="sort('id')" style="width: 5%">Id 
								<span class="glyphicon sort-icon" ng-show="sortType=='id'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" ></span>
							</th>
							<th ng-click="sort('email')" style="width: 30%">Email
								<span class="glyphicon sort-icon" ng-show="sortType=='email'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" ></span>
							</th>
							<th ng-click="sort('name')" style="width: 15%">Name 
								<span class="glyphicon sort-icon" ng-show="sortType=='name'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" >
							</th>
							<th ng-click="sort('created_at')" style="width: 20%">Created Date 
								<span class="glyphicon sort-icon" ng-show="sortType=='created_at'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" >
							</th>
							<th ng-click="sort('updated_at')" style="width: 20%">Updated Date 
								<span class="glyphicon sort-icon" ng-show="sortType=='updated_at'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" >
							</th>
							<th ng-click="sort('lastlogin')" style="width: 10%">Last Login 
								<span class="glyphicon sort-icon" ng-show="sortType=='lastlogin'" ng-class="{'glyphicon-chevron-up':!sortReverse,'glyphicon-chevron-down':sortReverse}" >
							</th>
						</tr>
					</thead>
					<tbody>
						<tr dir-paginate="user in users|orderBy:sortType:sortReverse|filter:searchUser|itemsPerPage:showitems" >
							<td><%user.id%></td>
							<td>
								<span><%user.email%></span>
								<div>
									<a href="javascript:void(0)" ng-click="modal('edit',user.id)">Edit </a>|
									<a href="javascript:void(0)" ng-click="deleteUser(user.id)"  ng-if="user.role_id!=2"> Delete</a>
								</div>
							</td>
							<td><%user.name%></td>
							<td><%user.created_at%></td>
							<td><%user.updated_at%></td>
							<td>2017-2-2 12:2:01</td>
						</tr>

					</tbody>
					<tfoot>
						<tr>
							<td colspan="100%">
								<dir-pagination-controls
							       max-size="5"
							       direction-links="true"
							       boundary-links="true">
							    </dir-pagination-controls>
							</td>
						</tr>
						
					</tfoot>
				</table>
				
			</div>
		</div>
		<a href="#loginModal" data-toggle="modal">modal login</a>


		<!-- Model create user  - one page  -->
	<div class="modal fade" id="modal-create-user">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><%titleModal%></h4>
				</div>
				<form action="#" method="post" name="frmCreate">
				<div class="modal-body">
						<div class="alert alert-danger" id="ng-errors-alert" style="display: none">
							<p id="ng-errors-message"><%error_message%></p>
						</div>

						<div id="modallogin-logininfo">
							<div class="para-title-admin">Login infomation</div>
							<div class="form-group row">
								<label for="email" class="control-label col-md-1 label-form-horizontal">Email: </label>
								<div class="col-md-6">
									<input type="email" ng-model="user.email" class="form-control" name="email" id="email" required="">
									<span class="errors" ng-show="(frmCreate.email.$dirty && frmCreate.email.$invalid)">
										<span ng-show="frmCreate.email.$error.email">Please enter a valid email address</span>
										<span ng-show="frmCreate.email.$error.required">Please enter a email</span>
									</span>
								</div>
							</div>
							<div ng-if="state =='edit'">
								<button type="button" id="btnchangepassword" class="btn btn-sm btn-warning col-md-offset-1" ng-click="toggleChange()">Change Password</button>
							</div>
							<div id="block-changepassword" ng-show="change">
								<div class="form-group row">
									<label for="password" class="control-label col-md-1 label-form-horizontal">Password: </label>
									<div class="col-md-6">
										<input type="password" ng-model="user.password" class="form-control" name="password" id="password" minlength="6">
										<span class="errors" ng-show="(frmCreate.password.$dirty && frmCreate.password.$invalid)">
											<span ng-show="frmCreate.password.$error.minlength">Password has at least 6 characters</span>
										</span>
									</div>
								</div>
								
								
								<div class="form-group row">
									<label for="repassword" class="control-label col-md-1 label-form-horizontal">Re-type Password: </label>
									<div class="col-md-6">
										<input type="password" ng-model="user.repassword" class="form-control" name="repassword" id="repassword" minlength="6">
										<span class="errors" ng-show="(frmCreate.repassword.$dirty && (frmCreate.repassword.$invalid || user.password!==user.repassword))">
											<span ng-show="frmCreate.repassword.$error.minlength">Re-type password has at least 6 characters</span>
											<span ng-show="user.password!=user.repassword">Confirm password not match</span>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div id="modallogin-userinfo">
							<div class="para-title-admin">User infomation</div>
							<div class="form-group row">
								<label for="name" class="control-label col-md-1 label-form-horizontal">Name: </label>
								<div class="col-md-6">
									<input type="text" class="form-control" ng-model="user.name" name="name" id="name" ng-required="true">
									<span class="errors" ng-show="(frmCreate.name.$dirty && frmCreate.name.$invalid)">
										<span ng-show="frmCreate.name.$error.required">Type a name</span>
									</span>
								</div>
							</div>
							
							<div class="form-group row">
								<label for="status" class="control-label col-md-1 label-form-horizontal">Status: </label>
								<div class="col-md-6">
									<select name="status" class="form-control" id="status" ng-model="user.status" required>
										<option value="1"  ng-selected="user.status==1">Active</option>
										<option value="0" ng-selected="user.status==0" >Non-active</option>
									</select>
									<span class="errors" ng-show="(frmCreate.status.$error.required)">
										Choose status
									</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="name" class="control-label col-md-1 label-form-horizontal">Role: </label>
								<div class="col-md-6">
									<select name="role_id" ng-model="user.role_id"  class="form-control" id="role" ng-options="role.id as role.name for role in roles" required>
									</select>
									<span class="errors" ng-show="(frmCreate.role_id.$error.required)">
										Choose role
									</span>
								</div>
							</div>
						</div>
						<div id="modallogin-permission">
							<div class="para-title-admin">Permission</div>
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Permission</th>
										<th>Manage All</th>
										<th>Enable View</th>
										<th>Enable Add</th>
										<th>Enable Update</th>
										<th>Enable Delete</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Manage All</td>
										<td><input type="checkbox" ></td>
										<td><input type="checkbox"></td>
										<td><input type="checkbox"></td>
										<td><input type="checkbox"></td>
										<td><input type="checkbox"></td>
									</tr>
									<tr>
										<td>Manage Admin</td>
										<td><input type="checkbox"></td>
										<td><input type="checkbox"></td>
										<td><input type="checkbox"></td>
										<td><input type="checkbox"></td>
										<td><input type="checkbox"></td>
									</tr>
									<tr>
										<td>Manage Employer</td>
										<td><input type="checkbox"></td>
										<td><input type="checkbox"></td>
										<td><input type="checkbox"></td>
										<td><input type="checkbox"></td>
										<td><input type="checkbox"></td>
									</tr>
								</tbody>
							</table>
						</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary"  ng-disabled="(frmCreate.$invalid || (user.password!==user.repassword))" ng-click="save(state,id)">Save changes</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	
@endsection