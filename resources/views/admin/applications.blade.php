@extends('admin.layout.new_master')
@section('primary-title') Applications Management @endsection
@section('secondary-title') List applications @endsection
@section('content')
<div ng-controller="ApplicationsController">
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
                        <th ng-click="sort('email')" style="width: 20%">Email
                            <span class="glyphicon sort-icon" ng-show="sort_type=='email'"
                                ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('fullname')" style="width: 15%">Full Name
                            <span class="glyphicon sort-icon" ng-show="sort_type=='fullname'"
                                ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('job.name')" style="width: 10%">Job Name
                            <span class="glyphicon sort-icon" ng-show="sort_type=='job.name'"
                                ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('employer.name')" style="width: 15%">Employer
                            <span class="glyphicon sort-icon" ng-show="sort_type=='employer.name'"
                                ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('created_at')" style="width: 20%">Created
                            <span class="glyphicon sort-icon" ng-show="sort_type=='created_at'"
                                ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr dir-paginate="item in applications|orderBy:sort_type:sort_reverse|filter:search_item|itemsPerPage:show_items">
                        <td>
                            <%item.email%>
                        </td>
                        <td>
                            <%item.fullname%>
                        </td>
                        <td>
                            <%item.job.name%>
                        </td>
                        <td>
                            <%item.employer.name%>
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
                    <h4 class="modal-title text-center">Application For <strong><%application.job.name%></strong> At <strong><%application.employer.name%></strong></h4>
                </div>
                <div class="modal-body">
                    <span>
                        <strong><i class="fa fa-map-marker margin-r-5"></i>Email: </strong>
                        <span class="text-muted"><%application.email%></span>
                    </span>
                    <hr>
                    <span>
                        <strong><i class="fa fa-map-marker margin-r-5"></i>Full name: </strong>
                        <span class="text-muted"><%application.fullname%></span>
                    </span>
                    <hr>
                    <span>
                        <strong ><i class="fa fa-map-marker margin-r-5"></i> Job name: </strong>
                        <span class="text-muted"><%application.job.name%></span>
                    </span>
                    <span class="col-md-offset-2">
                        <strong ><i class="fa fa-map-marker margin-r-5"></i> Employer name: </strong>
                        <span class="text-muted"><%application.employer.name%></span>
                    </span>
                    <hr>
                    <div>
                        <strong ><i class="fa fa-map-marker margin-r-5"></i> CV: </strong>
                        <a href="cv/views/<% application.cv %>" target="_blank" title="View CV"><span class="text-muted"><%application.cv%></span>
                        <i class="fa fa-download" aria-hidden="true"></i></a>
                    </div>
                    <div>
                        <strong ><i class="fa fa-map-marker margin-r-5"></i> Note: </strong>
                        <span class="text-muted"><%application.note%></span>
                    </div>


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
<script src="assets/angularjs/controller/ApplicationsController.js"></script>
@endsection
