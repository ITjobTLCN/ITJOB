@extends('admin.layout.master')  
@section('content')      
            <div class="container-fluid" ng-controller="UserController">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            User
                            <small>List</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Describe</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action <button type="button" class="btn btn-sm btn-outline-info" ng-click="modal('add')">Add</button></th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr ng-repeat="user in users">
                                    <td><img src="" alt="" width="100" height="100"></td>
                                    <td><%user.id%></td>
                                    <td><%user.name%></td>
                                    <td><%user.email%></td>
                                    <td><%user.describe%></td>
                                    <td><%user.role_id%></td>
                                    <td><%user.status%></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" ng-click="modal('edit',user.id)">Edit</button>
                                        <button type="button" class="btn btn-danger" ng-click="confirmDelete(user.id)">Delete</button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><strong><%frmTitle%></strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form name="frmUser" role="form">
                                        
                                            <div class="form-group">
                                                <label for="name">Tên</label>
                                                <input type="text" class="form-control" name="name" placeholder="Input field" ng-model="user.name" ng-required="true">
                                                <span class="error" ng-show="frmUser.name.$error.required">Tên không được để trống</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" ng-model="user.email" name="email" placeholder="Input field" ng-required="true" >
                                                <span class="error" ng-show="frmUser.email.$error.required">Email không được để trống</span>
                                                <span class="error" ng-show="frmUser.email.$error.email">Email không đúng định dạng</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="text" class="form-control" name="password" placeholder="Input field" ng-model="user.password" ng-required="true">
                                                <span class="error" ng-show="frmUser.password.$error.required">Password không được để trống</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="describe">Mô tả</label>
                                                <input type="text" class="form-control" name="describe" placeholder="Input field" ng-model="user.describe" >
                                            </div>

                                            <div class="form-group">
                                                <label for="role_id">Role</label>
                                                <select name="role_id" class="form-control" ng-model="user.role_id" ng-required="true">
                                                    <option value="" ng-model="user.role_id">-- Select One --</option>
                                                    <option value="1" ng-model="user.role_id">Admin</option>
                                                    <option value="2" ng-model="user.role_id">Nor-User</option>
                                                    <option value="3" ng-model="user.role_id">Emp-User</option>
                                                </select>
                                                <span class="error" ng-show="frmUser.role_id.$error.required">Vui lòng chọn role</span>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="status">Trạng thái</label>
                                                <div ng-init="user.status =1">
                                                    <label>
                                                        <input type="radio" name="status" ng-model="user.status" value="1" >
                                                        Acitive</label>
                                                    
                                                    <label>
                                                        <input type="radio" name="status" ng-model="user.status"  value="0" >
                                                        Inacitive</label>
                                                    
                                                </div>
                                                <span class="error" ng-show="frmUser.status.$error.required">Vui lòng chọn role</span>
                                            </div>
                                                
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" ng-disabled="frmUser.$invalid" ng-click="save(state,id)">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

					</div>
				</div>
            </div>
            <!-- /.container-fluid -->
@endsection
