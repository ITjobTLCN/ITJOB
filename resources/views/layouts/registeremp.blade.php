@extends('layouts.master')
@section('title')
Đăng ký nhà tuyển dụng | ITJob
@endsection
@section('body.content')
<div class="manager-account" ng-controller="HomeController" ng-init="loadReg()">
	<!-- content -->
	<div class="container">
		<div class="row main-content">
			<h1 class="text-center">
                <strong style="display: block">Chúng tôi cam kết</strong>
                <small>Đảm bảo hài lòng, hoặc miễn phí đăng lại tin tuyển dụng</small>
            </h1>
            <div class="col-sm-10 col-sm-offset-1 small text-center">
                <p>
                    <img src="https://images.vietnamworks.com/gen/badge-guaranteed.png" alt="Guarantee logo">
                </p>
                <p>Tuyển dụng tại Việt Nam là một việc đầy thử thách, vì thế chúng tôi luôn sẵn sàng hỗ trợ Quý khách. Nếu như Quý khách không <strong>hài lòng 100%</strong> với dịch vụ đăng tin tuyển dụng của ITJOB, hãy liên lạc với chuyên viên tư vấn của chúng tôi HCM: (84 28) 3925 8456 / HN: (84 24) 3944 0568 hoặc gửi thư về <a href="mailto:jobsupport@itjob.com">jobsupport@itjob.com</a> để yêu cầu được <strong>đăng lại miễn phí</strong> (không bao gồm các dịch vụ ưu tiên) trong vòng 10 ngày làm việc kể từ khi tin đăng tuyển có trả phí của Quý khách hết hạn. Chương trình không áp dụng cho các tin đăng lại hoặc các tin đăng tuyển miễn phí theo chương trình khuyến mại hoặc tin đăng tuyển hỗ trợ.</p>
            </div>
		</div>
		<div class="wrapper-profile row">
			<div class="box box-md">
				<div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
					<form action="#" method="POST" id="register_emp_form">
						<input type="hidden" name="empid" ng-model="curemp.empid" value="<%curemp.id%>">
						<div class="form-group">

							<label for="">Choose one:</label>
							<div class="row">
								<div class="col-md-8">
									<select ng-model="curemp" id="curemp" ng-options="emp.name for emp in emps track by emp._id" class="form-control" ng-change="new=false"></select>
								</div>
								<div class="col-md-4">
									<button type="button" class="btn btn-google btn-sm" ng-click="reset()">Reset</button>
								</div>
							</div>
							<!-- <%curemp%> -->
						</div>
						<div class="form-group">
							<label for="name" >Employer Name:</label>
							<input type="text" name="name"  class="form-control" placeholder="Employer name" ng-readonly="!new" ng-model="curemp.name">
						</div>
						<div class="form-group">
							<label for="">City</label>
							<select name="city_id" id="city_id" class="form-control" ng-options="item._id as item.name for item in cities" ng-readonly="!new" ng-model="curemp.city_id"></select>
						</div>
						<div class="form-group">
							<label for="address">Address</label>
							<input type="text" name="address" class="form-control" placeholder="Address" ng-readonly="!new" ng-model="curemp.address[0]['detail']">
						</div>
						<div class="form-group">
							<label for="website">Employer Website</label>
							<input type="text" name="website" class="form-control" placeholder="Link website" ng-readonly="!new" ng-model="curemp.website">
						</div>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="form-group">
							<div class="text-center" style="float: right">
								<button type="button" ng-click="submitReg()" class="btn btn-facebook">Send Request</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('footer.js')
<script src="assets/angularjs/controller/HomeController.js"></script>
@endsection