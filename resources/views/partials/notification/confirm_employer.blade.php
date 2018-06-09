@if($notification->data['status']==true)
<a href="{{route('getEmp')}}">
	You are <strong><i>excepted</i></strong> to be MASTER of <strong>{{$notification->data['emp']['name']}}</strong>
</a>
@else
<a href="#">
	You are <strong><i>denied</i></strong> to be MASTER of <strong>{{$notification->data['emp']['name']}}</strong>
</a>
@endif