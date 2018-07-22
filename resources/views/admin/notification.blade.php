@extends('admin.layout.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Send a notificaiton</div>

                <div class="panel-body">
                    <form action="{{route('createnotification')}}" method="POST" role="form">
                        <div class="form-group">
                            <input type="text" class="form-control" name="notification" placeholder="Notification">
                        </div>
                        <div class="form-group">
                        	<label for="who">To</label>
                            <select name="roleid" id="who" class="form-control">
                            	<option value="0">All</option>
                            	<option value="1">User</option>
                            	<option value="2">Admin</option>
                            	<option value="3">Employer</option>
                            	<option value="4">Assistant</option>
                            </select>
                        </div>

                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit" class="btn btn-primary">Send notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
