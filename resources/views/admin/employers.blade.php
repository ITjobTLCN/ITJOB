@extends('admin.layout.master')
@section('content')
<div class="container" ng-controller="EmpController">
	<div class="row">
		<div class="col">
			<div class="title-admin">Manage Employers</div>
			<div>
				<span class="table-title-admin">List Employers</span>
				<div class="btn-create-admin">
					<label class="label-show-items">
						<span>Show:</span>
						<select class="form-control input-sm" ng-model="show_items">
							<option value="3" ng-selected="show_items==3">3</option>
							<option value="5" ng-selected="show_items==5">5</option>
							<option value="10" ng-selected="show_items==10">10</option>
							<option value="20" ng-selected="show_items==20">20</option>
						</select>
					</label>
					<div class="input-group table-input-search">
						<span class="input-group-addon">
							<i class="fa fa-search"></i>
						</span>
						<input type="text" class="form-control " placeholder="Search..." ng-model="search">
					</div>
					<a href="javascript:void(0)" class="btn btn-outline btn-success btn-sm table-input-create" ng-click="modal('add')">Create employer</a>
				</div>
			</div>
			<table class="table table-responsive table-hover table-bordered table-angular">
				<thead class="thead-inverse">
					<tr class="info">
						<th ng-click="sort('name')" style="width: 15%">Name
							<span ng-show="sort_type=='name'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>
						<th ng-click="sort('info.description')" style="width: 20%">Description
							<span ng-show="sort_type=='info.description'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>
						<th ng-click="sort('info.website')" style="width: 20%">Website
							<span ng-show="sort_type=='info.website'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>
						<th ng-click="sort('info.phone')" style="width: 10%">Phone
							<span ng-show="sort_type=='info.phone'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>
						<th ng-click="sort('status')" style="width: 10%">Status
							<span ng-show="sort_type=='status'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>
						<th ng-click="sort('created_at')" style="width: 20%">Created Date
							<span ng-show="sort_type=='created_at'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>

						<th style="width: 5%">Actions</th>
					</tr>
				</thead>
				<tbody>
					<tr dir-paginate="emp in emps|orderBy:sort_type:sort_reverse|filter:search|filter: (flagStatus || '') && {status:filterStatus}|itemsPerPage:show_items"
					    id="content-table-admin">
						<td>
							<%emp.name%>
						</td>
						<td>
							<%emp.info.description%>
						</td>
						<td>
							<%emp.info.website%>
						</td>
						<td>
							<%emp.info.phone%>
						</td>
						<td>
							<div ng-switch="emp.status">
								<span ng-switch-when="1" class="label label-success">Actived</span>
								<span ng-switch-when="0" class="label label-danger">Deactived</span>
								<span ng-switch-when="2" class="label label-warning">Pending</span>
							</div>

						</td>
						<td>
							<%emp.created_at%>
						</td>
						<td>
							<button type="button" class="btn btn-info">View Detail</button>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="100%">
							<dir-pagination-controls max-size="5" direction-links="true" boundary-links="true">
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
					<h4 class="modal-title">
						<%titleModal%>
					</h4>
				</div>
				<form action="#" method="post">
					<div class="modal-body">
						<div class="alert alert-danger" id="errors_message" style="display: none">
							<%error_message%>
						</div>

						<div id="primary-info">

							<div class="container">
								<div class="para-title-admin">Employer infomation</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="name" class="control-label">Name: </label>
											<input type="text" ng-model="emp.name" class="form-control" name="name" required>
										</div>
										<div class="form-group">
											<label for="name" class="control-label">Description: </label>
											<input type="text" ng-model="emp.name" class="form-control" name="name" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="name" class="control-label">Phone: </label>
											<input type="text" ng-model="" class="form-control" name="website" required>
										</div>
										<div class="form-group">
											<label for="name" class="control-label">Website: </label>
											<input type="text" ng-model="" class="form-control" name="website" required>
										</div>
									</div>
								</div>
								<div class="para-title-admin">Master &#38; employee</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="master" class="control-label">Choose masters for employer (Maximum: 2): </label>
											<ui-select multiple ng-model="multiple.masters" theme="bootstrap" sortable="true" ng-disabled="false" style="width: 400px;" title="Choose a master">
												<ui-select-match placeholder="Select master..."><%$item.name%></ui-select-match>
												<ui-select-choices repeat="user in users | filter:$select.search">
												<%user.name%>
												</ui-select-choices>
											</ui-select>
											<p>Selected: <%multiple.masters %></p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="employee" class="control-label">Choose employees for employer (Maximum: 5): </label>
											<ui-select multiple ng-model="multiple.employees" theme="bootstrap" sortable="true" ng-disabled="false" style="width: 400px;" title="Choose a employee">
												<ui-select-match placeholder="Select employee..."><%$item.name%></ui-select-match>
												<ui-select-choices repeat="user in users | filter:$select.search">
												<%user.name%>
												</ui-select-choices>
											</ui-select>
											<p>Selected: <%multiple.employees %></p>
										</div>
									</div>
								</div>

								<div class="para-title-admin">Skills</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="master" class="control-label">Choose skills for employer: </label>
											<ui-select multiple ng-model="multiple.skills" theme="bootstrap" sortable="true" ng-disabled="false" style="width: 400px;" title="Choose a skill">
												<ui-select-match placeholder="Select skill..."><%$item.name%></ui-select-match>
												<ui-select-choices repeat="skill in skills | filter:$select.search">
												<%skill.name%>
												</ui-select-choices>
											</ui-select>
											<p>Selected: <%multiple.skills %></p>
										</div>
									</div>
								</div>

								<div class="para-title-admin">Addresses</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="master" class="control-label">Choose addresses for employer(Maximum: 2): </label>
											<ui-select multiple ng-model="multiple.cities" theme="bootstrap" ng-disabled="undefined" style="width: 100%;" title="Choose a city">
												<ui-select-match placeholder="Select city..."><%$item.name%></ui-select-match>
												<ui-select-choices repeat="city in cities | filter:$select.search">
												<%city.name%>
												</ui-select-choices>
											</ui-select>
											<p>Selected: <%multiple.cities %></p>
											<div ng-repeat="city in multiple.cities">
												<span><%city.name%></span>
												<input type="text" class="form-control" name="detail-<%city._id%>" placeholder="Address's detail in <%city.name%>">
											</div>
										</div>
									</div>
								</div>

								<div class="para-title-admin">Status</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<select name="status" class="form-control" id="status" ng-model="emp.status" required>
												<option value="1" ng-selected="emp.status==1">Active</option>
												<option value="0" ng-selected="emp.status==0">Deactive</option>
											</select>
										</div>
									</div>
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
