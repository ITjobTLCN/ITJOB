@extends('admin.layout.master') @section('content')
<div class="container" ng-controller="RolesController">
    <div class="row">
        <div class="col">
            <div class="title-admin">Manage roles</div>
            <div class="alert alert-danger" ng-show="errors_delete!=undefined">
                <p><%errors_delete%></p>
            </div>
            <div class="btn-create-admin">
                <label class="label-show-items">
                    <span>Show:</span>
                    <select class="form-control input-sm" ng-model="show_items">
                        <option value="3" ng-selected="show_items == 3">3</option>
                        <option value="5" ng-selected="show_items == 5">5</option>
                        <option value="10" ng-selected="show_items == 10">10</option>
                        <option value="20" ng-selected="show_items == 20">20</option>
                    </select>
                </label>
                <div class="input-group table-input-search">
                    <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" class="form-control " placeholder="Search..." ng-model="search_item">
                </div>
                <a href="javascript:void(0)" class="btn btn-outline btn-success btn-sm table-input-create" ng-click="modal(constant.MODAL_ADD)">Create roles</a>
            </div>
            <table class="table table-responsive table-hover table-bordered table-angular">
                <thead class="thead-inverse">
                    <tr class="info">
                        <th ng-click="sort('name')" style="width: 20%">Role
                            <span class="glyphicon sort-icon" ng-show="sort_type=='name'" ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('detail')" style="width: 20%">Detail
                            <span class="glyphicon sort-icon" ng-show="sort_type=='detail'" ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('route')" style="width: 20%">Route
                            <span class="glyphicon sort-icon" ng-show="sort_type=='route'" ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th ng-click="sort('created_at')" style="width: 20%">Created
                            <span class="glyphicon sort-icon" ng-show="sort_type=='created_at'" ng-class="{'glyphicon-chevron-up':!sort_reverse,'glyphicon-chevron-down':sort_reverse}"></span>
                        </th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr dir-paginate="item in roles|orderBy:sort_type:sort_reverse|filter:search_item|itemsPerPage:show_items">
                        <td>
                            <%item.name%>
                        </td>
                        <td>
                            <%item.detail%>
                        </td>
                        <td>
                            <%item.route%>
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
    </div>
    <!-- Modal -->
    <div class="modal fade" id="role_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><%role_modal_title%></h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="alert alert-danger" ng-show="errors!=undefined">
							<p><%errors%></p>
						</div>
                        <div class="form-group">
                            <label for="">Role name: </label>
                            <input type="text" class="form-control" placeholder="Enter role name" ng-model="role.name" >
                        </div>
                        <div class="form-group">
                            <label for="">Detail: </label>
                            <input type="text" class="form-control" placeholder="Enter role detail" ng-model="role.detail" >
                        </div>
                        <div class="form-group">
                            <label for="">Route: </label>
                            <input type="text" class="form-control" placeholder="Enter role route" ng-model="role.route" >
                        </div>
                        <button type="button" class="btn btn-primary" ng-click="save()">Save</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
