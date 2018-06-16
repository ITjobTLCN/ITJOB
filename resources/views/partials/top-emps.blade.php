<div class="hirring-now-side-bar col-md-3 col-sm-0">
	<h3 id="hirring">Top Employer</h3>
	<ul class="company-logos">
		@foreach($top_emps as $te)
		<li><a href="{{route('getEmployers',$te->alias)}}" target="_blank"><img width="110" alt="{{$te->name}}" title="{{$te->name}}" data-animation="false" src="uploads/emp/avatar/{{$te->images['avatar']}}""></a></li>
		@endforeach
	</ul>
</div>