@extends('employer.master')
@section('emptitle')
Manage Basic
@endsection
@section('empcontent')
	<div ng-controller="EmpMngController" ng-init="loadBasic({{$empid}})">
		<div id="emp-dashboard" class="emp-section">
			<div class="row" >
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
	                <div class="panel panel-success">
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
	                <div class="panel panel-warning">
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
	                <div class="panel panel-danger">
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
		</div>
		<div id="emp-yourpost" class="emp-section">
			<div class="row yourpost">
				<h1>Your posts <button type="button" class="btn btn-info" ng-click="addPost(0)"><i class="fa fa-plus-square-o"></i> New post</button></h1>
				<div class="col-lg-6 block-info">
					<table class="table table-hover table-responsive ">
						<h4 class="text-center">Your post in Company's name</h4>
						<thead>
							<tr >
								<th>Title</th>
								<th>Created</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr dir-paginate="post in myposts|itemsPerPage:3">
								<td><%post.name%></td>
								<td><%post.created_at%></td>
								<td>
									<span ng-if="post.status==0"><span class="label label-default">Saving</span></span>
									<span ng-if="post.status==1"><span class="label label-success">Publisher</span></span>
									<span ng-if="post.status==2"><span class="label label-danger">Deleted</span></span>
									<span ng-if="post.status==10"><span class="label label-warning">Pending</span></span>
									<span ng-if="post.status==11"><span class="label label-info">Expired</span></span>
								</td>
								<td>
									<div ng-if="post.status==0">
										<button type="button" ng-click="pushPost(post.id)" class="btn btn-sm btn-primary btn-zoom">Push</button>
										<button type="button" class="btn btn-sm btn-danger btn-zoom" ng-click="getPost(post.id)">Edit</button>
									</div>
									<button type="button" class="btn btn-sm btn-info btn-zoom">Preview</button>
								</td>
							</tr>
							
						</tbody>

					</table>
					<div class="text-center">
						<dir-pagination-controls 
							max-size="5">
						</dir-pagination-controls>
					</div>
				</div>
			</div>
			<div class="row newpost" style="display: none;" id="newpost">
				<div class="col block-info">
					<h2><%titleBlock%></h2>
					<form action="#" method="POST" role="form" name="formCreateJob" id="formCreateJob">
						<input type="hidden" value="{{csrf_token()}}" name="_token">
						<div class="row">
							<!-- Title and Content -->
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-lg-8">
										<label>Title:</label>
										<input type="text" name="name" ng-model="job.name" class="form-control" placeholder="Input title">
									</div>
									<div class="col-lg-4">
										<label>Post expire:</label>
										<input type="datetime-local" name="date_expire" ng-model="job.date_expire" class="form-control" >
									</div>									
								</div>
								<div class="form-group row">
									<div class="col-lg-4">
										<label for="">City</label>
										<select  class="form-control" ng-options="item.id as item.name for item in cities" ng-model="job.city_id" name="job.city_id">
										</select>
									</div>
									<div class="col-lg-8">
										<label for="">Address</label>
										<input type="text" class="form-control" placeholder="Input address" ng-model="job.address" name="address">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-6">
										<label for="">Salary</label>
										<input type="text" class="form-control" placeholder="Input salary range" ng-model="job.salary" name="salary">
									</div>
									<div class="col-lg-6">
										<label for="">Quantity</label>
										<input type="number" class="form-control" step="1" min="1" ng-model="job.quantity" name="">
									</div>
								</div>
								<div class="form-group">
									<label for="">Skills: </label>
									<span ng-repeat="sel in selection track by $index"><%sel.name%> <span ng-if="!$last">-</span> </span>
									<div>
										<button type="button" class="btn btn-primary btn-sm" ng-click="showSkill=!showSkill">Choose Skills <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
										<div id="listSkill" ng-show="showSkill">
											<input type="text" class="form-control" ng-model="searchSkill" placeholder="Search">
											<div class="single-skill" ng-repeat="skill in skills|filter:searchSkill">
												<label><input type="checkbox" value="<%skill.id%>" 
											  ng-checked="checked(skill.id)" ng-click="toggleSelection(skill.id,skill.name)"> <%skill.name%></label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="">Description</label>
									<textarea name="description" ng-model="job.description" class="form-control" cols="3" rows="3" ck-editor></textarea>
									<!-- <script type="text/javascript">
								      var editor = CKEDITOR.replace('job_description',{
								       language:'en',
								       filebrowserBrowseUrl :'assets/plugin/ckfinder/ckfinder.html',
								       filebrowserImageBrowseUrl : 'assets/plugin/ckfinder/ckfinder.html?type=Images',
								       filebrowserFlashBrowseUrl : 'assets/plugin/ckfinder/ckfinder.html?type=Flash',
								       filebrowserUploadUrl : 'assets/plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
								       filebrowserImageUploadUrl : 'assets/plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
								       filebrowserFlashUploadUrl : 'assets/plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
								       });
							      	</script> -->
								</div>
								<div class="form-group">
									<label for="">Requirement</label>
									<textarea name="require" ng-model="job.require" class="form-control" cols="3" rows="3"></textarea>
								</div>
								<div class="form-group">
									<label for="">Benefits</label>
									<textarea name="treatment" ng-model="job.treatment" class="form-control" cols="3" rows="3"></textarea>
								</div>
							</div>
							<!-- Tools:save,back,Send pending, move to trash preview, choose 3 image-->
							<div class="col-md-4">
								<div class="block-info">
									<div class="text-center">
										<button type="button" class="btn btn-primary" ng-click="savePost(typePost,idPost)">Save</button>
										<button type="button" class="btn btn-info">Preview</button>
									</div>
								</div>
								<div class="block-info">
									<div class="text-center">
										<button type="button" class="btn btn-default" ng-click="addPost()">Cancel</button>
										<button ng-if="typePost==1" ng-click="trashPost(idPost)" type="button" class="btn btn-default">Move to trash</button>
									</div>
								</div>
								<div class="block-info">
									<div class="form-group">
										<h4><strong>Status: </strong> Saving</h4>
									</div>
									<div class="form-group">
										<h4><strong>Created: </strong> 2-12-2017</h4>
									</div>
									<div class="form-group">
										<h4><strong>Updated: </strong> 2-12-2017</h4>
									</div>
								</div>
								<div class="block-info">
									<button type="button" class="btn btn-primary" ng-click="pushPost(idPost)" style="width:100%">Push and wait confirm</button>
								</div>
							</div>
						</div>
					</form>
					<!-- End form new post -->
				</div>
				<!-- End col new post-->
			</div>
			<!-- End row new post-->
			<div style="width: 100%;height:1000px;background-color:yellow;"></div>
		</div>
    </div>
@endsection
