@if($notification->data['status'])
<a href="{{route('getEmp')}}">
	You are <strong><i>excepted</i></strong> by Master "<strong>{{$notification->data['user']['name']}}</strong>" to be ASSISTANT of "<strong>{{$notification->data['employer']['name']}}</strong>"
</a>
@else
<a href="#">
	You are <strong><i>denied</i></strong> by Master "<strong>{{$notification->data['user']['name']}}</strong>" to be ASSISTANT of <strong>{{$notification->data['employer']['name']}}</strong>
</a>
@endif
