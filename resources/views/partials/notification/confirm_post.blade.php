@if($notification->data['status'])
<a href="{{route('detailjob', [$notification->data['post']['alias'], $notification->data['post']['_id']])}}" target="_blank">
	Your post "<strong><i>{{$notification->data['post']['name']}}</i></strong>" is approved by <strong>{{$notification->data['user']['name']}}</strong>. Discover right now!
</a>
@else
<a href="#">
	Your post "<strong><i>{{$notification->data['post']['name']}}</i></strong>" is denied by <strong>{{$notification->data['user']['name']}}</strong>
</a>
@endif