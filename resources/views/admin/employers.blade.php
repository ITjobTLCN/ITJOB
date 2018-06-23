@extends('admin.layout.new_master')
@section('primary-title') Employers Management @endsection
@section('secondary-title') List employers @endsection
@section('content')
<div ng-controller="EmpController">
    <div class="box">
        <div class="box-body">
			<div class="datatable-above">
                <span>Show: </span>
                <select class="form-control show-entries" ng-model="show_items">
                    <option value="3" ng-selected="show_items == 3">3</option>
                    <option value="5" ng-selected="show_items == 5">5</option>
                    <option value="10" ng-selected="show_items == 10">10</option>
                    <option value="20" ng-selected="show_items == 20">20</option>
                </select>
                <span>entries</span>
                <a href="javascript:void(0)" class="btn btn-flat btn-primary btn-add-new" ng-click="modal(constant.MODAL_ADD)" style="">Create employer</a>
                <div class="input-group datatable-search">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control " placeholder="Search..." ng-model="search_item">
                </div>
            </div>
			<table class="table table-responsive table-hover table-bordered">
				<thead class="thead-inverse">
					<tr class="info">
						<th ng-click="sort('name')" style="width: 15%">Name
							<span ng-show="sort_type=='name'" class="glyphicon sort-icon"
							ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>
						<th ng-click="sort('info.description')" style="width: 20%">Description
							<span ng-show="sort_type=='info.description'" class="glyphicon sort-icon"
							ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>
						<th ng-click="sort('info.website')" style="width: 20%">Website
							<span ng-show="sort_type=='info.website'" class="glyphicon sort-icon"
							ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>
						<th ng-click="sort('info.phone')" style="width: 10%">Phone
							<span ng-show="sort_type=='info.phone'" class="glyphicon sort-icon"
							ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>
						<th ng-click="sort('status')" style="width: 10%">Status
							<span ng-show="sort_type=='status'" class="glyphicon sort-icon"
							ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>
						<th ng-click="sort('created_at')" style="width: 20%">Created Date
							<span ng-show="sort_type=='created_at'" class="glyphicon sort-icon"
							ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>

						<th style="width: 5%">Actions</th>
					</tr>
				</thead>
				<tbody>
					<tr dir-paginate="emp in emps|orderBy:sort_type:sort_reverse|filter:search|itemsPerPage:show_items" id="content-table-admin">
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
								<span ng-switch-when="0" class="label label-danger">Deactivated</span>
								<span ng-switch-when="1" class="label label-primary">Actived</span>
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
						<label class="label-title">Employer infomation</label>
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
						<label class="label-title">Master &#38; employee</label>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="master" class="control-label">Choose masters for employer (Maximum: 2): </label>
									<ui-select multiple ng-model="multiple.masters" theme="bootstrap" sortable="true" ng-disabled="false" title="Choose a master">
										<ui-select-match placeholder="Select master..."><%$item.name%></ui-select-match>
										<ui-select-choices repeat="user in users | filter:$select.search">
										<%user.name%>
										</ui-select-choices>
									</ui-select>
									<p ng-repeat="master in multiple.masters"><% master.name %></p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="employee" class="control-label">Choose employees for employer (Maximum: 5): </label>
									<ui-select multiple ng-model="multiple.employees" theme="bootstrap" sortable="true" ng-disabled="false" title="Choose a employee">
										<ui-select-match placeholder="Select employee..."><%$item.name%></ui-select-match>
										<ui-select-choices repeat="user in users | filter:$select.search">
										<%user.name%>
										</ui-select-choices>
									</ui-select>
									<p>Selected: <%multiple.employees %></p>
								</div>
							</div>
						</div>

						<label class="label-title">Skills</label>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="master" class="control-label">Choose skills for employer: </label>
									<ui-select multiple ng-model="multiple.skills" theme="bootstrap" sortable="true" ng-disabled="false" title="Choose a skill">
										<ui-select-match placeholder="Select skill..."><%$item.name%></ui-select-match>
										<ui-select-choices repeat="skill in skills | filter:$select.search">
										<%skill.name%>
										</ui-select-choices>
									</ui-select>
									<p>Selected: <%multiple.skills %></p>
								</div>
							</div>
						</div>

						<label class="label-title">Addresses</label>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="master" class="control-label">Choose addresses for employer(Maximum: 2): </label>
									<ui-select multiple ng-model="multiple.cities" theme="bootstrap" ng-disabled="undefined" title="Choose a city">
										<ui-select-match placeholder="Select city..."><%$item.name%></ui-select-match>
										<ui-select-choices repeat="city in cities | filter:$select.search">
										<%city.name%>
										</ui-select-choices>
									</ui-select>
									<p>Selected: <%multiple.cities %></p>
									<label>Addresses detail</label>
									<div ng-repeat="city in multiple.cities" class="form-multi-address">
										<span><%city.name%></span>
										<input type="text" class="form-control" name="detail-<%city._id%>" placeholder="Address's detail in <%city.name%>">
									</div>
								</div>
							</div>
						</div>

						<label class="label-title">Status</label>
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
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" ng-disabled="(frmCreate.$invalid)" ng-click="save(state,id)">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
@section('script')
<script src="assets/angularjs/controller/EmpController.js"></script>
@endsection
