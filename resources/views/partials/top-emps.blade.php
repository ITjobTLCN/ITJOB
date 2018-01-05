<div class="hirring-now-side-bar col-md-3 col-sm-0">
	<h3 id="hirring">Top Employer</h3>
	<ul class="company-logos">
		@foreach($top_emps as $te)
		<li><a href=""><img width="110" alt="{{$te->name}}" title="{{$te->name}}" data-animation="false" src="https://cdn.itviec.com/system/production/employers/logos/114/misfit-logo-170-151.jpg?1463630640"></a></li>
		@endforeach
	</ul>
</div>