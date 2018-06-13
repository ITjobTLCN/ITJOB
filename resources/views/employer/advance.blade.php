@extends('employer.master')
@section('emptitle')
Manage Advance
@endsection
@section('empcontent')
<div  ng-controller="EmployerManagerController" ng-init="load()">
	<div class="emp-section" id="emp-info">
		<div class="info-ct">
			<h1>Your employer's infomation</h1>
			@if($errors->any())
			<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>{{$errors->first()}}</div>
			@endif
			<div class="row">
				<div class="col-lg-5">
					<p>Quản lý thông tin cơ bản này — tên của công ty, website, địa chỉ hay những thông tin khác sẽ được hiển thị ở trang Chi tiết công ty - Hãy điền những thông tin chính xác để các ứng viên tìm thấy bạn.</p>
				</div>
				<div class="col-lg-7">
					<form action="#" method="post" name="empInfo" class="block-info">
						<div class="text-right">
							<a href="javascript:void(0)" ng-click="editInfo()" ng-if="!editable"><i class="fa fa-edit"></i> Edit</a>
						</div>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="form-group row">
							<label class="col-md-3 form-control-label">Name</label>
							<div class="col-md-9">
								<span ng-show="!editable"><% employer['name'] %></span>
								<input type="text" ng-show="editable" ng-model="emp.name" class="form-control" name="name" placeholder="Employer's name" required>
								{{-- <span class="errors" ng-if="<% employer['name'] %>" ng-show="empInfo.name.$error.required">Please type employer's name</span> --}}
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">Webiste</label>
							<div class="col-md-9">
								<span ng-show="!editable"><% employer['info']['website'] %></span>
								<input type="text" ng-show="editable" class="form-control" name="website" placeholder="Employer's website" ng-model="emp.website" required>
								{{-- <span class="errors" ng-if="<% employer['info']['website'] %>" ng-show="empInfo.website.$error.required">Please type employer's website</span> --}}
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">City</label>
							<div class="col-md-9">
								<span ng-show="!editable"><% employer['city_id'] %></span>
								<select ng-show="editable" class="form-control" name="" id="" ng-options="item.id as item.name for item in cities" ng-model="emp.city_id">
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">Address</label>
							<div class="col-md-9">
								<span ng-show="!editable"><% employer['address'][0]['detail'] %></span>
								<input ng-show="editable" type="text" class="form-control" name="address" placeholder="Employer's address" ng-model="emp.address" required>
								{{-- <span class="errors" ng-if="<% employer['address'][0]['detail'] %>" ng-show="empInfo.address.$error.required">Please type employer's address</span> --}}
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">Phone</label>
							<div class="col-md-9">
								<span ng-show="!editable"><% employer['info']['phone'] %></span>
								<input ng-show="editable" type="text" class="form-control" name="phone" placeholder="Employer's phone" ng-model="emp.phone">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">Description</label>
							<div class="col-md-9">
								<p ng-show="!editable"><% employer['info']['description'] %></p>
								<textarea ng-show="editable" ng-model="emp.description" name="description" class="form-control" rows="5"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 form-control-label">Schedule</label>
							<div class="col-md-9">
								<span ng-show="!editable"><% emp.schedule%></span>
								<input ng-show="editable" type="text" class="form-control" name="schedule" placeholder="Employer's schedule" ng-model="emp.schedule">
							</div>
						</div>

						{{-- <div class="form-group row">
							<label class="col-md-3 form-control-label">Overtime</label>
							<div class="col-md-9 checkbox">
								<span ng-show="!editable">
									<span ng-if="emp.overtime==1">OVT</span>
									<span ng-if="emp.overtime==0">No</span>
								</span>
								<label ng-show="editable">
									<input type="checkbox" name="overtime" id="overtime" ng-model="emp.overtime" ng-true-value="1" ng-false-value="0"> OVT</label>
							</div>
						</div> --}}

						<div class="form-group row">
							<label class="col-md-3 form-control-label">Our Skills</label>
							<div class="col-md-9">
								<span ng-repeat="sel in selection track by $index"><%sel.name%> <span ng-if="!$last">-</span> </span>
								<div ng-show="editable">
									<div>
									<button type="button" class="btn btn-primary btn-sm" ng-click="showSkill=!showSkill">Choose Skills &gt;</button>
									<div id="listSkill" ng-show="showSkill">
										<input type="text" class="form-control" ng-model="searchSkill" placeholder="Search">
										<div class="single-skill" ng-repeat="skill in skills|filter:searchSkill">
											<label>
												<input type="checkbox" value="<%skill._id%>"
										  ng-checked="checked(skill._id)" ng-click="toggleSelection(skill._id, skill.name)"> <%skill.name%></label>
										</div>
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row justify" ng-if="editable">
							<div class=" col text-center">
								<button ng-disabled="empInfo.$invalid" type="button" class="btn btn-warning" ng-click="updateInfo()">Change</button>
								<button type="button" ng-click="editInfo()" class="btn btn-default">Back</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-7">
					<div class="block-info">
						<div id="cover-info">
							<img ng-src="uploads/emp/cover/<% employer['images']['cover'] %>" alt="<% emp.cover%>">
							<div class="cover-above" id="cover-above-cover">
								<button type="button" class="btn btn-success" ng-click="fileCover(1)">Click to change your cover</button>
								<form action="{{route('postChangeLogoCover',[$employer['_id'], 1])}}" method="post" enctype="multipart/form-data" id="formChangeCover">
									<input type="hidden" value="{{csrf_token()}}" name="_token">
									<input type="file" name="file" ng-show="false" id="filecover">
								</form>	
							</div>
						</div>
						<div id="logo-info">
							<img ng-src="uploads/emp/logo/<% employer['images']['avatar'] %>" alt="<% emp.logo%>">
							<div class="cover-above" id="cover-above-logo">
								<button type="button" class="btn btn-sm btn-success" ng-click="fileCover(2)">Change logo</button>
								<form action="{{route('postChangeLogoCover',[$employer['_id'], 2])}}" method="post" enctype="multipart/form-data" id="formChangeLogo">
									<input type="hidden" value="{{csrf_token()}}" name="_token">
									<input type="file" name="file" ng-show="false" id="filelogo">
								</form>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="emp-section" id="emp-assistant">
		<div>
			<span  class="table-title-admin">Manage Assistants</span>
			<div class="btn-create-admin" >
				<label class="label-show-items">
					<span>Show:</span>
					<select class="form-control input-sm"  ng-model="showitems">
						<option value="3" ng-selected="showitems == 3">3</option>
						<option value="5" ng-selected="showitems == 5">5</option>
						<option value="10" ng-selected="showitems == 10">10</option>
						<option value="20" ng-selected="showitems == 20">20</option>
					</select>
				</label>
				<div class="input-group table-input-search">
					<span class="input-group-addon"><i class="fa fa-search"></i></span>
					<input type="text" class="form-control " placeholder="Search..." ng-model="search">
				</div>
			</div>
		</div>
		<table class="table table-responsive table-hover table-bordered table-angular">
			<thead class="thead-inverse">
				<tr class="info">
					<th ng-click="sort('id')" style="width: 5%">Id
						<span ng-show="sortType=='id'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
					</th>
					<th ng-click="sort('name')" style="width: 10%">Name
						<span ng-show="sortType=='name'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
					</th>
					<th ng-click="sort('email')" style="width: 20%">Email
						<span ng-show="sortType=='email'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
					</th>


					<th ng-click="sort('created_at')" style="width: 10%">Register Date
						<span ng-show="sortType=='created_at'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReverse,'glyphicon-chevron-up':!sortReverse}"></span>
					</th>

					<th style="width: 15%">Status
						<div>
							<span ng-click="filter(11)" class="label label-success"><i class="fa fa-filter"></i></span>
							<span ng-click="filter(10)" class="label label-warning"><i class="fa fa-filter"></i></span>
							<span ng-click="filter(12)" class="label label-danger"><i class="fa fa-filter"></i></span>
						</div>
					</th>
					<th style="width: 15%">Quick Confirm</th>
				</tr>
			</thead>
			<tbody>
				<tr dir-paginate="assis in assistant|orderBy:sortType:sortReverse|filter:search|filter: (flagStatus || '') && {status:filterStatus}|itemsPerPage:showitems" pagination-id="assis" id="content-table-admin">
					<td><%assis._id%></td>
					<td>
						<span><% assis['user']['name'] %></span>
					</td>
					<td><% assis['user']['email'] %></td>
					<td><% assis.created_at %></td>
					<td>
						<span ng-if="assis.status == 11" class="label label-success">Approved</span>
						<span ng-if="assis.status == 10" class="label label-warning">Pending</span>
						<span ng-if="assis.status == 12" class="label label-danger">Denied</span>
					</td>
					<td>
						<span ng-if="assis.status == 10">
							<button ng-click="confirm(assis.user_id)" class="btn btn-sm btn-success">Confirm</button>
							<button ng-click="deny(assis._id)" class="btn btn-sm btn-danger">Deny</button>
						</span>
						<span ng-if="ass.status == 11">Last: <%ass.lastlogin%></span>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="100%">
						<dir-pagination-controls pagination-id="assis"
					       max-size="5"
					       direction-links="true"
					       boundary-links="true">
					    </dir-pagination-controls>
					</td>
				</tr>

			</tfoot>
		</table>

	</div>
	<!-- manage posts include: view, publisher pending posts,pull to saving , infos, stop post (set date_expire NOW), delete post -->
	<div class="emp-section" id="emp-post">
		<div>
			<span class="table-title-admin">Manage Posts</span>
			<div class="btn-create-admin" >
				<label class="label-show-items">
					<span>Show: </span>
					<select class="form-control input-sm"  ng-model="showitemsPost">
						<option value="3" ng-selected="showitemsPost == 3">3</option>
						<option value="5" ng-selected="showitemsPost == 5">5</option>
						<option value="10" ng-selected="showitemsPost == 10">10</option>
						<option value="20" ng-selected="showitemsPost == 20">20</option>
					</select>
				</label>
				<div class="input-group table-input-search">
					<span class="input-group-addon"><i class="fa fa-search"></i></span>
					<input type="text" class="form-control " placeholder="Search..." ng-model="searchPost">
				</div>
			</div>
		</div>
		<table class="table table-responsive table-hover table-bordered table-angular">
			<thead class="thead-inverse">
				<tr class="info">
					<th ng-click="sortPost('_id')">Id
						<span ng-show="sortTypePost == 'id'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReversePost,'glyphicon-chevron-up':!sortReversePost}"></span>
					</th>
					<th ng-click="sortPost('updated_at')" >Time
						<span ng-show="sortTypePost == 'updated_at'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReversePost,'glyphicon-chevron-up':!sortReversePost}"></span>
					</th>
					<th ng-click="sortPost('name')">Title
						<span ng-show="sortTypePost == 'name'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReversePost,'glyphicon-chevron-up':!sortReversePost}"></span>
					</th>

					<th ng-click="sortPost('user.name')">Author
						<span ng-show="sortTypePost == 'user.name'" class="glyphicon sort-icon" ng-class="{'glyphicon-chevron-down':sortReversePost,'glyphicon-chevron-up':!sortReversePost}"></span>
					</th>

					<th>Status
						<div>
							<span ng-click="filterPost(10)" class="label label-warning"><i class="fa fa-filter"></i></span>
							<span ng-click="filterPost(1)" class="label label-success"><i class="fa fa-filter"></i></span>
							<span ng-click="filterPost(11)" class="label label-info"><i class="fa fa-filter"></i></span>
							<span ng-click="filterPost(12)" class="label label-danger"><i class="fa fa-filter"></i></span>
						</div>
					</th>
					<th>Action</th>
					<th>Applied</th>
				</tr>
			</thead>
			<tbody>
				<%filterStatusPost%>
				<%flagStatusPost%>
				<tr dir-paginate="post in posts|orderBy:sortTypePost:sortReversePost|filter:searchPost|filter: (flagStatusPost || '') &&  {status:filterStatusPost}|itemsPerPage:showitemsPost" pagination-id="posts" id="content-table-admin">
					<td><%post._id%></td>
					<td>
						<span><% post.updated_at %></span>
					</td>
					<td><% post.name %></td>
					<td><% post['user']['name']%></td>
					<td>
						<span ng-show="post.status == 0" class="label label-default">Saving</span>
						<span ng-show="post.status == 1" class="label label-success">Publisher</span>
						<span ng-show="post.status == 2" class="label label-danger">Deleted</span>
						<span ng-show="post.status == 10" class="label label-warning">Pending</span>
						<span ng-show="post.status == 11" class="label label-info">Expired</span>
						<span ng-show="post.status == 12" class="label label-danger">Master deleted</span>
					</td>
					<td>
						<span ng-if="post.status == 10">
							<button ng-click="confirmPost(post._id)" class="btn btn-sm btn-success">Confirm</button>
							<button ng-click="denyPost(post._id)" class="btn btn-sm btn-danger">Deny</button>
						</span>
					</td>
					<td><%post.applications.length%>/<%post.detail.quantity%>
						<span ng-if="post.detail.quantity == null">*</span>
						<a href="javascript:void(0)" ng-click="showApps(post)"><span class="fa fa-arrow-circle-right"></span></a>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="100%">
						<dir-pagination-controls pagination-id="posts"
					       max-size="5"
					       direction-links="true"
					       boundary-links="true">
					    </dir-pagination-controls>
					</td>
				</tr>
			</tfoot>
		</table>
		<!-- List of Applications of Current Post -->
		@include('partials.list-apps')
	</div>

</div>
@endsection