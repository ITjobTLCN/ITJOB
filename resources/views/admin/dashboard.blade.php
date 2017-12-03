@extends('admin.layout.master')
@section('content')
	<div class="container" ng-controller="DashBoardController">
		<div class="row">
			<div class="col">
				<div  class="title-admin">DashBoard</div>	
			</div>
		</div>
		<div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">26</div>
                                <div>New Comments!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">12</div>
                                <div>New Tasks!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">124</div>
                                <div>New Orders!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-support fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">13</div>
                                <div>Support Tickets!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-6">
        		<div class="panel panel-warning">
        			<div class="panel-heading text-center">
        				<i class="fa fa-users fa-2x"></i>
        				<span class="title-panel">Users</span>
        				<div class="title-panel-number"><%countallusers%></div>
        			</div>
        			<div class="panel-body">
        				<table class="table table-condensed table-admin">
        					<tbody>
        						<tr>
        							<td>Admin</td>
        							<th><%countadmins%></th>
        						</tr>
        						<tr>
        							<td>User</td>
        							<th><%countusers%></th>
        						</tr>
        						<tr>
        							<td>Employer
										<ul>
											<li class="small-num">Master</li>
											<li class="small-num">Assistant</li>
										</ul>
        							</td>
        							<th><%countemployers%>
										<ul>
											<li class="small-num"><%countmasters%></li>
											<li class="small-num"><%countassistants%></li>
										</ul>
        							</th>
        						</tr>
        					</tbody>
        				</table>
        				<div>
        					<label class="label-show-items">
        						<span>Show by</span> 
								<select name="" id="select-admin-panel" class="form-control">
									<option value="" selected>All</option>
									<option value="" >Day</option>
									<option value="" >Week</option>
									<option value="" >Month</option>
									<option value="" >Year</option>
								</select>
							</label>
        				</div>
        			</div>
        		</div>
        	</div>
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">
                        <i class="fa fa-user-secret fa-2x"></i>
                        <span class="title-panel">Employers</span>
                        <div class="title-panel-number"><%countemps%></div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-condensed table-admin">
                            <tbody>
                                <tr>
                                    <td>Actived</td>
                                    <th><%countapprovedemps%></th>
                                </tr>
                                <tr>
                                    <td>Pending</td>
                                    <th><%countpendingemps%></th>
                                </tr>
                                <tr>
                                   <td>Denied</td>
                                   <th><%countdeniedemps%></th>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                            <label class="label-show-items">
                                <span>Show by</span> 
                                <select name="" id="select-admin-panel" class="form-control">
                                    <option value="" selected>All</option>
                                    <option value="" >Day</option>
                                    <option value="" >Week</option>
                                    <option value="" >Month</option>
                                    <option value="" >Year</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>

@endsection