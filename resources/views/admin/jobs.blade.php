@extends('admin.layout.new_master')
@section('primary-title') Jobs Management @endsection
@section('secondary-title') List jobs @endsection
@section('content')
<div ng-controller="JobsController">
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
                        <th ng-click="sort('name')" style="width: 20%">Job name
                            <span class="glyphicon sort-icon" ng-show="sort_type=='name'"
                                ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('employer.name')" style="width: 20%">Employer name
                            <span class="glyphicon sort-icon" ng-show="sort_type=='employer.name'"
                                ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('status')" style="width: 10%">Status
							<span ng-show="sort_type=='status'" class="glyphicon sort-icon"
							ng-class="{'glyphicon-chevron-down':sort_reverse,'glyphicon-chevron-up':!sort_reverse}"></span>
						</th>
                        <th ng-click="sort('created_at')" style="width: 20%">Created
                            <span class="glyphicon sort-icon" ng-show="sort_type=='created_at'"
                                ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr dir-paginate="item in jobs|orderBy:sort_type:sort_reverse|filter:search_item|itemsPerPage:show_items">
                        <td>
                            <%item.name%>
                        </td>
                        <td>
                            <%item.employer.name%>
                        </td>
                        <td>
                            <div ng-switch="item.status">
								<span ng-switch-when="0" class="label label-danger">Deactivated/Denied</span>
								<span ng-switch-when="1" class="label label-primary">Actived/Approved</span>
								<span ng-switch-when="2" class="label label-warning">Pending</span>
							</div>
                        </td>
                        <td>
                            <%item.created_at%>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info" ng-click="modal(constant.MODAL_DETAIL, item)">View detail</button>
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
    <!-- Modal -->
    <div class="modal fade" id="modal_detail" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><%job.name%></h4>
                </div>
                <div class="modal-body">
                    <span>
                        <strong><i class="fa fa-map-marker margin-r-5"></i>Post by: </strong>
                        <span class="text-muted"><%job.created_by.name%></span>
                    </span>
                    <span class="col-md-offset-2">
                        <strong ><i class="fa fa-map-marker margin-r-5"></i> Employer name: </strong>
                        <span class="text-muted"><%job.employer.name%></span>
                    </span>
                    <div>
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Address: </strong>
                        <span class="text-muted"><%job.employer.address[0].detail%></span>
                    </div>
                    <hr>

                    <strong><i class="fa fa-book margin-r-5"></i> Description</strong>
                    <p class="text-muted" ><%job.detail.description%></p>
                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> Requirement</strong>
                    <p class="text-muted"><%job.detail.requirement%></p>
                    <hr>

                    <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
                    <p>
                        <span ng-repeat="skill in skills" ng-if="(job) &amp;&amp; inArraySkill(skill._id, job.skills_id)" class="label label-success margin-r-5"><%skill.name%></span>
                    </p>
                    <hr>

                    <strong>
                        <i class="fa fa-map-marker margin-r-5"></i> Quantity:
                        <span><%job.detail.quantity%></span>
                    </strong>
                    <strong class="col-md-offset-2">
                        <i class="fa fa-map-marker margin-r-5"></i> Salary:
                        <span><%job.detail.salary%></span>
                    </strong>
                    <strong class="col-md-offset-2"><i class="fa fa-file-text-o margin-r-5"></i> Users following:
                        <span><%job.quantity_user_follow%></span>
                    </strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="assets/angularjs/controller/JobsController.js"></script>
@endsection
