@if($notification->data['status']==true)
<a href="{{route('detailjob',[$notification->data['post']['alias'],$notification->data['post']['id']])}}">
	Your post "<strong><i>{{$notification->data['post']['name']}}</i></strong>" is approved by <strong>{{$notification->data['user']['name']}}</strong>. Discover rightnow!
</a>
@else
<a href="#">
	Your post "<strong><i>{{$notification->data['post']['name']}}</i></strong>" is denied by <strong>{{$notification->data['user']['name']}}</strong>
</a>
@endif