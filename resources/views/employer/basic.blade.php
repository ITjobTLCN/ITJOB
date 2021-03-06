@extends('employer.master')
@section('emptitle')
Manage Basic
@endsection
@section('empcontent')
	<div ng-controller="EmployerManagerController">
		<div id="emp-dashboard" class="emp-section" ng-init="loadBasic()">
			<div class="row">
	            <div class="col-lg-3 col-md-6">
	                <div class="panel panel-primary">
	                    <div class="panel-heading">
	                        <div class="row">
	                            <div class="col-xs-3 huge">
	                                <i class="fa fa-newspaper-o fa-5x"></i>
	                            </div>
	                            <div class="col-xs-9 text-right">
	                                <div class="huge"><% options['posts'].length %><span class="huge-new">(<%options['countPostToday']%> new)</span>
	                                </div>
	                                <div>Post!</div>
	                            </div>
	                        </div>
	                    </div>
	                    <a href="javascrip:void(0)" ng-click="expend('post')">
	                        <div class="panel-footer">
	                            <span class="pull-left">View Details</span>
	                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                            <div class="clearfix"></div>
	                        </div>
	                    </a>
	                </div>
	            </div>
	            <div class="col-lg-3 col-md-6">
	                <div class="panel panel-success">
	                    <div class="panel-heading">
	                        <div class="row">
	                            <div class="col-xs-3 huge">
	                                <i class="fa fa-file-code-o fa-5x"></i>
	                            </div>
	                            <div class="col-xs-9 text-right">
	                                <div class="huge"><% options['applies'].length %><span class="huge-new">(<% options['countApplyToday'] %> new)</span></div>
	                                <div>Application!</div>
	                            </div>
	                        </div>
	                    </div>
	                    <a href="javascrip:void(0)" ng-click="expend('apply')">
	                        <div class="panel-footer">
	                            <span class="pull-left">View Details</span>
	                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                            <div class="clearfix"></div>
	                        </div>
	                    </a>
	                </div>
	            </div>
	            <div class="col-lg-3 col-md-6">
	                <div class="panel panel-warning">
	                    <div class="panel-heading">
	                        <div class="row">
	                            <div class="col-xs-3 huge">
	                                <i class="fa fa-list-ul fa-5x"></i>
	                            </div>
	                            <div class="col-xs-9 text-right">
	                                <div class="huge"><% options['reviews'].length %><span class="huge-new">(<% options['countReviewToday']%> new)</span></div>
	                                <div>Review!</div>
	                            </div>
	                        </div>
	                    </div>
	                    <a href="javascrip:void(0)" ng-click="expend('review')">
	                        <div class="panel-footer">
	                            <span class="pull-left">View Details</span>
	                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                            <div class="clearfix"></div>
	                        </div>
	                    </a>
	                </div>
	            </div>
	            <div class="col-lg-3 col-md-6">
	                <div class="panel panel-danger">
	                    <div class="panel-heading">
	                        <div class="row">
	                            <div class="col-xs-3 huge">
	                                <i class="fa fa-heart "></i>
	                            </div>
	                            <div class="col-xs-9 text-right">
	                                <div class="huge"><% options['follows'].length %><span class="huge-new">(<% options['countReviewToday']%> new)</span></div>
	                                <div>Follow!</div>
	                            </div>
	                        </div>
	                    </div>
	                    <a href="javascrip:void(0)" ng-click="expend('follow')">
	                        <div class="panel-footer">
	                            <span class="pull-left">View Details</span>
	                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                            <div class="clearfix"></div>
	                        </div>
	                    </a>
	                </div>
	            </div>
	            <div class="col-md-12" >
	            	<table class="table table-bordered table-striped table-responsive"
	            	ng-if="expendFlag && expendType == 'post'">
	            		<thead >
	            			<tr class="info">
	            				<th>Title</th>
	            				<th>Author</th>
	            				<th>Create at</th>
	            				<th>Date Expired</th>
	            				<th>Applied</th>
	            			</tr>
	            		</thead>
	            		<tbody>
	            			<tr dir-paginate="post in options['posts']|orderBy:created_at:true|itemsPerPage:5" pagination-id="post">
	            				<td><a ng-href="<% detailJob(post.alias, post._id) %>" target="_blank"><% post.name %></a></td>
	            				<td><% post.user.name %></td>
	            				<td><% post.created_at %></td>
	            				<td><% post.date_expired %></td>
	            				<td><% post.applications.length %>/<% post.detail.quantity %>
									<span ng-if="post.detail.quantity == null">all</span></td>
	            			</tr>
	            			<tr>
	            				<td colspan="100%" class="text-center">
	            					<dir-pagination-controls pagination-id="post"
									max-size="5"
									direction-links="true"
					       			boundary-links="true">
	            					</dir-pagination-controls>
	            				</td>
	            			</tr>
	            		</tbody>
	            	</table>
	            	<table class="table table-bordered table-striped table-responsive" ng-if="expendFlag && expendType == 'apply'">
	            		<thead >
	            			<tr class="info">
	            				<th>Name</th>
	            				<th>Email</th>
	            				<th>Time</th>
	            				<th>Post</th>
	            				<th>CV</th>
	            			</tr>
	            		</thead>
	            		<tbody>
	            			<tr dir-paginate="apply in options['applies']|orderBy:created_at:true|itemsPerPage:5" pagination-id="application">
	            				<td><% apply.fullname %></td>
	            				<td><% apply.email %></td>
	            				<td><% apply.created_at %></td>
	            				<td><% apply.job.name %></td>
	            				<td><a href="cv/views/<% apply.cv %>" target="_blank"><% apply.cv %></a></td>
	            			</tr>
	            			<tr>
	            				<td colspan="100%" class="text-center">
	            					<dir-pagination-controls pagination-id="application"
									max-size="5"
									direction-links="true"
					       			boundary-links="true">
	            					</dir-pagination-controls>
	            				</td>
	            			</tr>
	            		</tbody>
	            	</table>
	            	<table class="table table-bordered table-striped table-responsive"  ng-if="expendFlag==true && expendType=='review'">
	            		<thead >
	            			<tr class="info">
	            				<th>User</th>
	            				<th>Title</th>
	            				<th>Rating</th>
	            				<th>Time</th>
	            				<th>Like</th>
	            				<th>Unlike</th>
	            			</tr>
	            		</thead>
	            		<tbody>
	            			<tr dir-paginate="review in options['reviews']|orderBy:created_at:true|itemsPerPage:5" pagination-id="review">
	            				<td><% review.reviewed_by %></td>
	            				<td><% review.title %></td>
	            				<td><% review.rating %></td>
	            				<td><% review.reviewed_at %></td>
	            				<td><% review.like %></td>
	            				<td><% review.unlike %></td>
	            			</tr>
	            			<tr>
	            				<td colspan="100%" class="text-center">
	            					<dir-pagination-controls pagination-id="review"
									max-size="5"
									 direction-links="true"
					       			boundary-links="true">
	            					</dir-pagination-controls>
	            				</td>
	            			</tr>
	            		</tbody>
	            	</table>
	            	<table class="table table-bordered table-striped table-responsive"  ng-if="expendFlag==true && expendType=='follow'">
	            		<thead >
	            			<tr class="info">
	            				<th>User</th>
	            				<th>Time</th>
	            			</tr>
	            		</thead>
	            		<tbody>
	            			<tr dir-paginate="follow in options['follows']|orderBy:created_at:true|itemsPerPage:5" pagination-id="follow">
	            				<td><% follow.user.name %></td>
	            				<td><% follow.created_at %></td>
	            			</tr>
	            			<tr>
	            				<td colspan="100%" class="text-center" >
	            					<dir-pagination-controls pagination-id="follow"
	            					max-size="5"
	            					direction="true"
	            					boundary-links="true">
	            					</dir-pagination-controls>
	            				</td>
	            			</tr>
	            		</tbody>
	            	</table>
	            </div>
	            <div class="col-md-12">
	            		<button type="button" ng-show="expendFlag == true" ng-click="expendFlag = !expendFlag" class="btn btn-danger" style="float: right">Close</button>
	            	</div>
	        </div>
		</div>
		<div id="emp-yourpost" class="emp-section">
			<div class="row yourpost">
				<h1>Your posts <button type="button" class="btn btn-info" ng-click="addPost(0)"><i class="fa fa-plus-square-o"></i> New post</button></h1>
				<div class="col-lg-7 block-info">
					<table class="table table-hover table-responsive ">
						<h4 class="text-center">Your post in <% emp.name %></h4>
						<thead>
							<tr>
								<th>Title</th>
								<th>Created</th>
								<th>Status</th>
								<th>Action</th>
								<th>Applied</th>
							</tr>
						</thead>
						<tbody>
							<tr dir-paginate="post in options['myPosts']|itemsPerPage:3" pagination-id="mypost">
								<td><% post.name %></td>
								<td><% post.created_at %></td>
								<td>
									<span ng-if="post.status == 0"><span class="label label-default">Saving</span></span>
									<span ng-if="post.status == 1"><span class="label label-success">Publisher</span></span>
									<span ng-if="post.status == 2"><span class="label label-danger">Deleted</span></span>
									<span ng-if="post.status == 10"><span class="label label-warning">Pending</span></span>
									<span ng-if="post.status == 11"><span class="label label-info">Expired</span></span>
									<span ng-if="post.status == 12"><span class="label label-danger">Denied</span></span>
								</td>
								<td>
									<div ng-if="post.status == 0">
										<button type="button" ng-click="pushPost(post._id)" class="btn btn-sm btn-facebook btn-zoom">Push</button>
										<button type="button" class="btn btn-sm btn-google btn-zoom" ng-click="getPost(post._id)">Edit</button>
									</div>
									<button type="button" class="btn btn-sm btn-google btn-zoom" ng-if="post.status == 1" ng-click="trashPost(post._id)">Delete</button>
									<button type="button" class="btn btn-sm btn-info btn-zoom" ng-if="post.status == 2" ng-click="reStorePost(post._id)">Restore</button>
								</td>
								<td><% post.applications.length %>/<% post.detail.quantity %>
									<span ng-if="post.detail.quantity == null">all</span>
									<a href="javascript:void(0)" ng-click="showApps(post)"><span class="fa fa-arrow-circle-right" data-toggle="tooltip" title="View Applications"></span></a>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="text-center">
						<dir-pagination-controls pagination-id="mypost"
							max-size="5">
						</dir-pagination-controls>
					</div>
				</div>
			</div>
			<div class="row newpost" style="display: none;" id="newpost">
				<div class="col block-info">
					<h2><%titleBlock%></h2>
					<form action="#" method="POST" role="form" name="formCreateJob" id="formCreateJob">
						{{ csrf_field() }}
						<div class="row">
							<!-- Title and Content -->
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-lg-7">
										<label>Title:</label>
										<input type="text" name="name" ng-model="job.name" class="form-control" placeholder="Input title">
									</div>
									<div class="col-lg-5">
										<label>Day expired:</label>
										<input type="datetime-local" name="date_expire" ng-model="job.date_expired" class="form-control" >
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-4">
										<label for="">City</label>
										<select  class="form-control" ng-options="item.name for item in cities" ng-model="job.city" name="job.city">
										</select>
									</div>
									<div class="col-lg-4">
										<label for="">Salary ($)</label>
										<input type="text" class="form-control" placeholder="Input salary range" ng-model="job.salary" name="salary"> 
									</div>
									<div class="col-lg-4">
										<label for="">Quantity</label>
										<input type="number" class="form-control" step="1" min="1" ng-model="job.quantity" name="quantity" placeholder="Type quantity employee">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-12">
										<label for="">Address</label>
										<textarea class="form-control" ng-model="job.address" name="address" cols="3" rows="3" placeholder="Type your company address"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="">Skills: </label>
									<span ng-repeat="sel in selection track by $index" style="color: red"><%sel.name%> <span ng-if="!$last" >-</span> </span>
									<div>
										<button type="button" class="btn btn-facebook btn-sm" ng-click="showSkill=!showSkill">Choose Skills <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
										<div id="listSkill" ng-show="showSkill">
											<input type="text" class="form-control" ng-model="searchSkill" placeholder="Search">
											<div class="single-skill" ng-repeat="skill in skills|filter:searchSkill">
												<label><input type="checkbox" value="<%skill._id%>"
											  ng-checked="checked(skill._id)" ng-click="toggleSelection(skill._id, skill.name)"> <% skill.name %></label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="">Description</label>
									<textarea name="description" ng-model="job.description" class="form-control" cols="3" rows="3" ck-editor></textarea>

								</div>
								<div class="form-group">
									<label for="">Requirement</label>
									<textarea name="require" ng-model="job.require" class="form-control" cols="3" rows="3"></textarea>
								</div>
								<div class="form-group">
									<label for="">Benefits</label>
									<textarea name="benefit" ng-model="job.benefit" class="form-control" cols="3" rows="3"></textarea>
								</div>
							</div>
							<!-- Tools:save,back,Send pending, move to trash preview, choose 3 image-->
							<div class="col-md-4">
								<div class="block-info">
									<div class="text-center">
										<button type="button" class="btn btn-facebook" ng-click="savePost(typePost, idPost)" style="margin-right: 10px; width: 100%">Save</Iutton>
									</div>
								</div>
								<div class="block-info">
									<div class="text-center">
										<button type="button" class="btn btn-default" ng-click="addPost()" style="margin-right: 10px">Cancel</button>
										<button ng-if="typePost == 1" ng-click="trashPost(job._id)" type="button" class="btn btn-google">Delete</button>
									</div>
								</div>
								<div class="block-info">
									<div class="form-group">
										<h4><strong>Status: </strong> Saving</h4>
									</div>
									<div class="form-group">
										<h4><strong>Created: </strong> <% job.created_at %></h4>
									</div>
									<div class="form-group">
										<h4><strong>Updated: </strong> <% job.updated_at %></h4>
									</div>
								</div>

								<div class="block-info">
									<button type="button" class="btn btn-facebook" ng-click="pushPost(idPost)" style="width:100%">Push and wait confirm</button>
								</div>
							</div>
						</div>
					</form>
					<!-- End form new post -->
				</div>
				<!-- End col new post-->
			</div>
			<!-- End row new post-->
		</div>
		@include('partials.list-apps')
    </div>
@endsection
