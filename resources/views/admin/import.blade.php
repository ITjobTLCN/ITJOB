@extends('admin.layout.master')
@section('content')
	<div class="container">
		<div class="row justify-content-md-center">
			<div class="col-md-6">
				@if(Session::has('message'))
				<div class="alert">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>{{Session::get('message')}}</strong>
				</div>
				@endif
				<form action="{{route('postimport')}}" method="POST" enctype="multipart/form-data">
					<legend>IMPORT EXCEL</legend>
					<label for="">Chọn bảng</label>
					<div class="form-group row">
						<div class="col-md-10">
							<select name="type"  class="form-control" required="required" id="type">
								<option value="1">Users</option>
								<option value="2">Cities</option>
								<option value="3">Jobs</option>
								<option value="4">Employers</option>
								<option value="5">Skills</option>
								<option value="6">Skill_Job</option>
								<option value="7">Applications</option>
								<option value="8">Roles</option>
							</select>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-outline-danger col-md-offset-1" id="btn-export">Export</button>
						</div>
					</div>
					
					<div class="form-group">
						<label for="">File</label>
						<input type="file" name="file" class="form-control">
					</div>
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="text-center">
						<button type="submit" class="btn btn-outline-secondary w-75">Submit</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>
	<div style="height: 400px;">
		
	</div>
@endsection
@section('script')
	<script>
		$('#btn-export').click(function(){
			var selected_type = $('#type').val();
			// alert(selected_type);
			window.location.href = 'export/'+selected_type;
		})
	</script>
@endsection