<div id="listApplications" class="block-info" ng-show="showListPosts">
	<h1>List Applications
		<a href="javascript:void(0)" class="pull-right" ng-click="showListPosts = false" data-toggle="tooltip" title="Close"><i class="fa fa-window-close-o"></i></a>
	</h1>
	<h3>Post: <span><% curPost.name %></span></h3>
	<h3>Date publisher: <span><% curPost.updated_at %></span></h3>
	<h3>Date expired: <span><% curPost['date_expired'] %></span></h3>
	<h3>Applied: <span><% curPost.applications.length %>/<% curPost.detail.quantity %>
		<span ng-if="curPost.detail.quantity == null">all</span>
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
				<td><% app.fullname %></td>
				<td><% app.email %></td>
				<td><% app.created_at %></td>
				<td><a href="cv/views/<% app.cv %>" target="_blank"><% app.cv %></a></td>
				<td>
					<a href="#modal-sendemailemp" ng-click="getApplication(app.fullname, app.email)" data-toggle="modal" data-target="#modal-sendemailemp" class="btn btn-sm btn-primary">Email</a>
				</td>
			</tr>
			<tr ng-if='curPost.applications.length == 0'>
				<td colspan="5" class="text-center"><span>Not found</span></td>
			</tr>
		</tbody>
	</table>
	{{-- @if(Session::has('flash_message'))
		{{Session::get('flash_message')}}
	@endif --}}
	<div class="modal fade" id="modal-sendemailemp">
		<div class="modal-dialog modal-lg">
			<form action="{{route('postSendEmail')}}" method="POST">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title">Company: <% employer.name %></h3>
					<h4 class="modal-title">Send email to candicate</h4>
				</div>
				<div class="modal-body">
						<div class="row">
							<div class="form-group col-md-6">
								<label for="email" class="form-control-label">To</label>
								<input type="email" name="email" class="form-control" placeholder="Email" ng-model="infoSendMail.email" readonly="readonly">
							</div>
							<div class="form-group col-md-3">
								<label for="date" class="form-control-label">Choose Date</label>
								<input type="date" class="form-control" name="date" ng-model="emailDate" ng-change="updateEmail()">
							</div>
							<div class="form-group col-md-3">
								<label for="hour" class="form-control-label" >Choose Hour</label>
								<input type="time" class="form-control" name="hour" ng-model="emailHour" ng-change="updateEmail()">
							</div>
						</div>
						<div class="form-group">
							<label for="address" class="form-control-label">Address:</label>
							<input type="text" name="address" class="form-control" placeholder="Address" ng-model="employer.address" ng-change="updateEmail()">
						</div>

						<strong>Email content:</strong>
						<div class="form-group">
							<div class="col-sm-12">
								<textarea type="text" name="contentemail" ng-model="emailContent" data-ck-editor></textarea>
							</div>
						</div>

						<input type="hidden" name="_token" value="{{csrf_token()}}">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Send</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

				</form>
			</div>
		</div>
	</div>
</div>