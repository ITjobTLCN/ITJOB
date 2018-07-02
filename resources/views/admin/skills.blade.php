@extends('admin.layout.new_master')
@section('primary-title') Skills Management @endsection
@section('secondary-title') List skills @endsection
@section('content')
<div ng-controller="SkillsController">
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
                <a href="javascript:void(0)" class="btn btn-flat btn-primary btn-add-new" ng-click="modal(constant.MODAL_ADD)" style="">Create skill</a>
                <div class="input-group datatable-search">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control " placeholder="Search..." ng-model="search_item">
                </div>
            </div>

            <table class="table table-responsive table-hover table-bordered">
                <thead class="thead-inverse">
                    <tr class="info">
                        <th ng-click="sort('name')" style="width: 20%">Skill
                            <span class="glyphicon sort-icon" ng-show="sort_type=='name'" ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('created_at')" style="width: 20%">Created
                            <span class="glyphicon sort-icon" ng-show="sort_type=='created_at'" ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr dir-paginate="item in skills|orderBy:sort_type:sort_reverse|filter:search_item|itemsPerPage:show_items">
                        <td>
                            <%item.name%>
                        </td>
                        <td>
                            <%item.created_at%>
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning" ng-click="modal(constant.MODAL_EDIT, item)">Edit</button>
                            <button type="button" class="btn btn-danger" ng-click="delete(item._id)">Delete</button>
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
                    <h4 class="modal-title"><%modal_title%></h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="alert alert-danger" ng-show="errors!=undefined">
							<p><%errors%></p>
						</div>
                        <div class="form-group">
                            <label for="">Skill: </label>
                            <input type="text" class="form-control" placeholder="Enter skill" ng-model="skill.name" >
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" ng-click="save()">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="assets/angularjs/controller/SkillsController.js"></script>
@endsection
