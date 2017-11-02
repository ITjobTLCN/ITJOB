<div class="search-widget clearfix">
	<div class="row">
		<h2>Find your dream jobs. Be success!</h2>
	</div>
	<div class="row">
		<form class="form-inline" role="form" method="get" action="{{route('list-job-search')}}">
			<div class="form-group col-sm-6 col-md-6 col-lg-7 keyword-search">
				<i class="fa fa-search" aria-hidden="true"></i>
				<input type="hidden" name="idtp" ng-model="idtp">
				@if(Session::has('skillname'))
				<input type="text" id="keyword" name="keysearch" class="typeahead form-control" value="{{Session::get('skillname')}}" placeholder="Keyword skill (Java, iOS,...),..">
				@else
				<input type="text" id="keyword" name="keysearch" class="typeahead form-control" placeholder="Keyword skill (Java, iOS,...),..">
				@endif
			</div>
			<div class="form-group col-sm-3 col-md-3 col-lg-3 location-search">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
				@if(Session::has('city'))
				<input class="form-control dropdown-toggle" id="nametp" name="nametp" placeholder="City" data-toggle="dropdown" value="{{Session::get('city')}}">
				@else
				<input class="form-control dropdown-toggle" id="nametp" name="nametp" placeholder="City" data-toggle="dropdown">
				@endif
				<ul class="dropdown-menu">
					@foreach(Cache::get('listLocation') as $c)
						<li><p id="loca">{{$c->name}}</p></li>
					@endforeach
				</ul>
			</div>
			<div class="form-group col-sm-3 col-md-3 col-lg-2">
				<input type="submit" class="btn btn-default btn-search" value="Search" >
			</div>
		</form>
	</div>
</div>