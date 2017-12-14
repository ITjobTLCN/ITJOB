<div id="listApplications" class="block-info" ng-show="showListPosts">
	<h1>List Applications
		<a href="javascript:void(0)" class="pull-right" ng-click="showListPosts=false"><i class="fa fa-window-close-o"></i></a>
	</h1>
	<h3>Post: <span><%curPost.name%></span></h3>
	<h3>Date publisher: <span><%curPost.updated_at%></span></h3>
	<h3>Date expired: <span><%curPost.date_expire%></span></h3>
	<h3>Applied: <span><%curPost.applications.length%>/<%curPost.quantity%>
		<span ng-if="curPost.quantity==null">all</span>
	</span></h3>
	<table class="table table-hover table-bordered table-responsive">
		<thead>
			<tr class="warning">
				<th>Name</th>
				<th>Email</th>
				<th>Time</th>
				<th>CV</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="app in curPost.applications|orderBy:created_at:false">
				<td><%app.name%></td>
				<td><%app.email%></td>
				<td><%app.created_at%></td>
				<td><a href="downloadcv/<%app.cv%>"><%app.cv%></a></td>
				<td>
					
				</td>
			</tr>
		</tbody>
	</table>
</div>