@extends('admin.layout.master')
@section('content')
<div class="container" ng-controller="EmpController">
	<div class="row">
		<div class="col">
			<div  class="title-admin">Manage</div>
			<div>
				<span  class="table-title-admin">Administrator Employers</span>
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
    					<input type="text" class="form-control " placeholder="Search..." ng-model="search">
					</div>
					<a href="javascript:void(0)" class="btn btn-outline btn-success btn-sm table-input-create" ng-click="modal('add')">Create employer</a>
				</div>
			</div>	
			<table class="table table-responsive table-hover table-bordered table-angular">
				<thead class="thead-inverse">
					<tr class="info">
						<th ng-click="sort('id')" style="width: 5%">Id
							<span ng-show="sortType=='id'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
						</th>
						<th ng-click="sort('name')" style="width: 10%">Name
							<span ng-show="sortType=='name'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
						</th>
						<th ng-click="sort('address')" style="width: 25%">Address
							<span ng-show="sortType=='address'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
						</th>
						<th ng-click="sort('website')" style="width: 10%">Website
							<span ng-show="sortType=='website'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
						</th>
						<th ng-click="sort('personel')" style="width: 10%">Personel
							<span ng-show="sortType=='personel'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
						</th>
						<th ng-click="sort('post')" style="width: 10%">No. Posts
							<span ng-show="sortType=='post'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
						</th>
						<th ng-click="sort('created_at')" style="width: 10%">Created Date
							<span ng-show="sortType=='created_at'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
						</th>
						<th ng-click="sort('updated_at')" style="width: 10%">Last Updated
							<span ng-show="sortType=='updated_at'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
						</th>
						<th ng-click="sort('lastlogin')" style="width: 10%">Last Login
							<span ng-show="sortType=='lastlogin'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr dir-paginate="emp in emps|orderBy:sortType:sortReverse|filter:search|itemsPerPage:showitems" >
						<td><%emp.id%></td>
						<td>
							<span><%emp.name%></span>
							<div>
								<a href="javascript:void(0)" ng-click="modal('edit',emp.id)">Edit</a>|
								<a href="javascript:void(0)" ng-click="delete(emp.id)"> Delete</a>
							</div>
						</td>
						<td><%emp.address%></td>
						<td><%emp.website%></td>
						<td>xxx</td>
						<td>xxx</td>
						<td><%emp.created_at%></td>
						<td><%emp.updated_at%></td>
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
		<!-- end col -->
	</div>
	<!-- endrow -->

		<!-- Model create/edit employer  - one page  -->
	<div class="modal fade" id="modal-emp">
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

					<div id="primary-info">
						<div class="para-title-admin">Employer infomation</div>
						<div class="form-group row">
							<label for="name" class="control-label col-md-1 label-form-horizontal">Name: </label>
							<div class="col-md-6">
								<input type="text" ng-model="emp.name" class="form-control" name="name" id="name" required>
								<span class="errors" ng-show="(frmCreate.name.$dirty && frmCreate.name.$invalid)">
									<span ng-show="frmCreate.name.$error.required">Please type employer's name</span>
								</span>
							</div>
						</div>
						<div class="form-group row">
							<label for="city_id" class="control-label col-md-1 label-form-horizontal">City: </label>
							<div class="col-md-6">
								<select name="city_id" ng-model="emp.city_id"  class="form-control" id="city_id" ng-options="city.id as city.name for city in cities" ng-init="emp.city_id=1" required>
								</select>
								<span class="errors" ng-show="(frmCreate.city_id.$error.required)">
									Must choose city
								</span>
							</div>
						</div>
						<div class="form-group row">
							<label for="address" class="control-label col-md-1 label-form-horizontal">Address: </label>
							<div class="col-md-6">
								<input type="text" ng-model="emp.address" class="form-control" name="address" id="address" required>
								<span class="errors" ng-show="(frmCreate.address.$dirty && frmCreate.address.$invalid)">
									<span ng-show="frmCreate.address.$error.required">Please type employer's address</span>
								</span>
							</div>
						</div>
						<div class="form-group row">
							<label for="website" class="control-label col-md-1 label-form-horizontal">Website: </label>
							<div class="col-md-6">
								<input type="text" ng-model="emp.website" class="form-control" name="website" id="website" required>
								<span class="errors" ng-show="(frmCreate.website.$dirty && frmCreate.website.$invalid)">
									<span ng-show="frmCreate.website.$error.required">Please type employer's website</span>
								</span>
							</div>
						</div>
						<div class="form-group row">
							<label for="status" class="control-label col-md-1 label-form-horizontal">Status: </label>
							<div class="col-md-6">
								<select name="status" class="form-control" id="status" ng-model="emp.status" required>
									<option value="1" ng-selected="emp.status===1">Active</option>
									<option value="0" ng-selected="emp.status===0">Non-active</option>
								</select>
								<span class="errors" ng-show="(frmCreate.status.$error.required)">
									Choose status
								</span>
							</div>
						</div>

					</div>
					<div id="extend-info">
						<div class="para-title-admin">Extend infomation</div>
						<div class="form-group row">
							<label for="phone" class="control-label col-md-1 label-form-horizontal">Phone: </label>
							<div class="col-md-6">
								<input type="text" ng-model="emp.phone" class="form-control" name="phone" id="phone">
							</div>
						</div>
					</div>		
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" ng-disabled="(frmCreate.$invalid)" ng-click="save(state,id)">Save changes</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
	
@endsection