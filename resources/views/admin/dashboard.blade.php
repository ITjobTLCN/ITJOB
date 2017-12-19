@extends('admin.layout.master')
@section('content')
	<div class="container" ng-controller="DashBoardController" ng-init="loadDashboard()">
		<div class="row">
			<div class="col">
				<div  class="title-admin">DashBoard</div>	
			</div>
            <h3 >Today: <span><%clock | date:'dd-MM-yyyy HH:mm:ss'%></span></h3>
		</div>
        <%now%>
		<div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-podcast fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><%useronline%></div>
                                <div>Online!</div>
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
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><%countusertoday%></div>
                                <div>New Users!</div>
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
                                <i class="fa fa-newspaper-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><%countposttoday%></div>
                                <div>New Posts!</div>
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
                                <i class="fa fa-file-code-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><%countapplitoday%></div>
                                <div>New Applications!</div>
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
        	<div class="col-md-4">
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
        							<td>Master(emp)</td>
        							<th><%countmasters%></th>
        						</tr>
                                <tr>
                                    <td>Assistant(emp)</td>
                                    <th><%countassistants%></th>
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
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">
                        <i class="fa fa-user-secret fa-2x"></i>
                        <span class="title-panel">Companies</span>
                        <div class="title-panel-number">
                            <span class="sub-count sub-count-danger"><%countdeniedemps%></span>
                            <%countapprovedemps%>
                            <span class="sub-count sub-count-warning"><%countpendingemps%></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-condensed table-admin">
                            <tbody>
                                <tr>
                                    <td>New</td>
                                    <th><%newemps%></th>
                                </tr>
                                <tr>
                                    <td>Posted</td>
                                    <th><%countposted%></th>
                                </tr>
                                <tr>
                                    <td>Applied</td>
                                    <th><%countapplies%></th>
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
        <!-- end row -->
        <div class="row">
            <div class="col-md-8">
                <table class="table table-hover table-responsive table-striped table-bordered">
                    <h4>Top post views </h4>
                    <thead>
                        <tr>
                            <th width="60%" class="text-center">Title</th>
                            <th width="20%" class="text-center">Com.</th>
                            <th class="text-center">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="post in posts|orderBy:views:true|limitTo:5">
                            <td><a href=""><%post.name%></a></td>
                            <td><a href=""><%post.employer.name%></a></td>
                            <td><%post.views%></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
    
@endsection