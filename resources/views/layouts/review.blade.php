@extends('layouts.master')
@section('title')
Review Company | ITJob
@endsection
@section('body.content')
<div class="container">
	<div class="review-company">
		<div class="row">
			<div class="col-md-8 col-sm-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading text-center">
						<h2 class="panel-title">Review</h2>
						<h3 class="company-name">{{$company->name}}</h3>
						<span class="under-line"></span>
					</div>
					<div class="panel-body" ng-controller="CompanyController">
						<p><i class="fa fa-quote-left fa-3x fa-pull-left fa-border" aria-hidden="true"></i> Bạn chỉ mất 1 phút để hoàn thành bảng đánh giá này. </p>
						<p>Ý kiến của bạn sẽ giúp ích rất nhiều cho cộng đồng Developer đang tìm việc.</p>
						<form class="review-form" action="{{route('reviewCompany',$company->alias)}}" method="POST">
							{{csrf_field()}}
							<div class="form-group">
								@if(session('message'))
								<div class="alert alert-success result">{{session('message')}}</div>
								@endif
								<label for="title">Đánh giá tổng quát</label>
								<div class="br-widget">
									<input type="hidden" name="cStar"  id="cStar" value="1">
									<input type="hidden" name="emp_id" id="emp_id" value="{{$company->id}}">
									<a href="" class="btn btn-default" id="add-star">+</a>
									<div class="star-review">
										<a href="" id="star1"><i class="fa fa-star" aria-hidden="true"></i></a>
									</div>
									<a href="" class="btn btn-default" id="sub-star">-</a>
									<span id="type-review">Phân vân</span>
								</div>
							</div>
							<div class="form-group">
								<label for="">Tiêu đề</label>
								<input type="text" name="title" class="form-control" placeholder="Tiêu đề: Tóm tắt đánh giá...." id="title">
							</div>
							<div class="form-group">
								<label for="">Điều bạn thích</label>
								<textarea id="like" name="like" class="form-control" placeholder="Điều gì làm công ty này nổi bật? Ví dụ: &quot;Bãi đậu xe rộng rãi. Văn phòng đẹp tất cả đều được trang bị hàng &quot;Apple&quot; (Macbook, iMac)&quot;" id="" cols="30" rows="5"></textarea>
							</div>
						<div class="form-group">
								<label for="">Điều bạn không thích</label>
								<textarea id="unlike" name="unlike" class="form-control" placeholder="Bạn nghĩ công ty cần cải thiện điều gì? Ví dụ: &quot;Khi có dự án thì OT hơi nhiều, áp lực, nên cần cải thiện khâu estimation. Họp và báo cáo nhiều gây mất thời gian, nên giảm các việc này.&quot;" id="" cols="30" rows="5"></textarea>
							</div>
							<div class="form-group">
								<label for="">Góp ý của bạn</label>
								<textarea id="suggest" name="suggest" class="form-control" placeholder="Chia sẻ giúp công ty hoàn thiện hơn" id="" cols="30" rows="3"></textarea>
							</div>
							<div class="form-group">
								<label for="">Bạn có muốn giới thiệu công ty này đến bạn bè của mình ?</label>
								<div class="recommend-to-friend">
									<input type="hidden" name="recommend" id="recommend" value="1">
									<div class="recommend yes active" id="yes">
										<span><i class="fa fa-thumbs-o-up"></i></span>
									</div>
									<div class="clearfix"></div>
									<div class="recommend no" id="no">
										<span><i class="fa fa-thumbs-o-down"></i></span>
									</div>
								</div>
								
							</div>
							<button type="submit" class="btn btn-danger">Review</button>
						</form>
						<div class="modal fade" id="modal-id">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title">Modal title</h4>
									</div>
									<div class="modal-body">
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary">Save changes</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-0 hidden-sm hidden-xs">
				<div class="panel panel-default review-policites">
					<div class="panel-heading">
						<h2 class="panel-title">Hướng Dẫn &amp; Điều Kiện Về Đánh Giá</h2>
					</div>
					<div class="panel-body">
						<p>
							<i class="fa fa-quote-left fa-3x fa-pull-left fa-border" aria-hidden="true"></i> Mọi đánh giá phải tuân thủ Hướng Dẫn &amp; Điều Kiện về đánh giá để được hiển thị trên website.
						</p>
						<p>
							Xin vui lòng:
						</p><ul>
							<li>Không sử dụng từ ngữ mang ý xúc phạm, miệt thị</li>
							<li>Không cung cấp thông tin cá nhân</li>
							<li>Không cung cấp thông tin bảo mật, bí mật kinh doanh của công ty</li>
						</ul>
						<p></p>
						<p>
							Cảm ơn bạn đã đưa ra những đánh giá chân thực nhất. Xem thêm thông tin chi tiết về Hướng Dẫn &amp; Điều Kiện về đánh giá
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('footer.js')
<script src="assets/js/myscript.js"></script>
<script src="assets/controller/CompanyController.js"></script>
<script src="assets/JQuery/jquery.validate.min.js"></script>
<script src="assets/js/validate-form.js"></script>
@endsection