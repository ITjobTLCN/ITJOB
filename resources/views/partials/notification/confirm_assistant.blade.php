@if($notification->data['status']==true)
<a href="{{route('getEmp')}}">
	You are <strong><i>excepted</i></strong> by Master "<strong>{{$notification->data['user']['name']}}</strong>" to be ASSISTANT of "<strong>{{$notification->data['emp']['name']}}</strong>"
</a>
@else
<a href="#">
	You are <strong><i>denied</i></strong> by Master "<strong>{{$notification->data['user']['name']}}</strong>" to be ASSISTANT of <strong>{{$notification->data['emp']['name']}}</strong>
</a>
@endif