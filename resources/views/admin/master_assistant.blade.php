@extends('admin.layout.new_master')
@section('primary-title') Masters &amp; Assistants @endsection
@section('secondary-title') List masters and assistants @endsection
@section('content')
<div ng-controller="EmpController" data-ng-init="init()">
    <div class="box">
        <div class="box-body">
            <div ng-show="errors_delete!=undefined">
                <p class="text-red"><%errors_delete%></p>
            </div>
            <div class="datatable-above">
                <span>Show: </span>
                <select class="form-control show-entries" ng-model="show_items">
                    <option value="3" ng-selected="show_items == 3">3</option>
                    <option value="5" ng-selected="show_items == 5">5</option>
                    <option value="10" ng-selected="show_items == 10">10</option>
                    <option value="20" ng-selected="show_items == 20">20</option>
                </select>
                <span>entries</span>
                <div class="input-group datatable-search">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control " placeholder="Search..." ng-model="search_item">
                </div>
            </div>

            <table class="table table-responsive table-hover table-bordered">
                <thead class="thead-inverse">
                    <tr class="info">
                        <th ng-click="sort('name')" style="width: 20%">Name
                            <span class="glyphicon sort-icon" ng-show="sort_type=='name'" ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('detail')">Role
                            <span class="glyphicon sort-icon" ng-show="sort_type=='detail'" ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('employer.name')" style="width: 20%">Employer
                            <span class="glyphicon sort-icon" ng-show="sort_type=='employer.name'" ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('route')" style="width: 20%">Status
                            <span class="glyphicon sort-icon" ng-show="sort_type=='route'" ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('created_at')" style="width: 20%">Created At
                            <span class="glyphicon sort-icon" ng-show="sort_type=='created_at'" ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr dir-paginate="item in list_master_assis|orderBy:sort_type:sort_reverse|filter:search_item|itemsPerPage:show_items">
                        <td>
                            <%item.user.name%>
                        </td>
                        <td>
                            <%item.user.roles.name%>
                        </td>
                        <td>
                            <%item.employer.name%>
                        </td>
                        <td>
                            <div ng-switch="item.status">
								<span ng-switch-when="0" class="label label-warning">Pending</span>
								<span ng-switch-when="1" class="label label-success">Actived</span>
								<span ng-switch-when="2" class="label label-default">Inactive</span>
								<span ng-switch-when="10" class="label label-warning">Pending Assistant</span>
								<span ng-switch-when="11" class="label label-success">Actived Assistant</span>
								<span ng-switch-when="12" class="label label-default">Inactive Assistant</span>
							</div>
                        </td>
                        <td>
                            <%item.created_at%>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm"
                                ng-if="item.status == 0 || item.status == 2"
                                ng-click="activate(item._id, constant.STATUS.ACTIVATE)">Activate</button>
                            <button type="button" class="btn btn-danger btn-sm"
                                ng-if="item.status == 0 || item.status == 1"
                                ng-click="activate(item._id, constant.STATUS.DEACTIVATE)">Deactivate</button>
                        </td>
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
</div>

@endsection
@section('script')
<script src="assets/angularjs/controller/EmpController.js"></script>
@endsection
