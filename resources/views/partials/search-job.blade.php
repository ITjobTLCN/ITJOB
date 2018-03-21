
				<form class="form-inline" role="form" method="get" action="{{route('seachJob')}}">
					<div class="form-group col-sm-6 col-md-6 col-lg-7 keyword-search">
						<i class="fa fa-search" aria-hidden="true"></i>
						@if(Session::has('jobname'))
						<input type="text" id="keyword" name="q" class="typeahead form-control" 
						value="{{Session::get('jobname')}}" placeholder="Keyword job title, company...">
						@else
						<input type="text" id="keyword" name="q" class="typeahead form-control" placeholder="Keyword job title, company...">
						@endif
						<span id="close"><i class="fa fa-times" aria-hidden="true"></i></span>
					</div>
					<div class="form-group col-sm-3 col-md-3 col-lg-3 location-search" ng-controller="SearchController as ctrl">
					<ui-select ng-model="ctrl.city.selected"  theme="select2" on-select="onSelected($item)">
							
							<ui-select-match placeholder="Select location">
								<% $select.selected.name || $select.selected %>
								<input type="hidden" name="cname" value="<% $select.selected.name || $select.selected %>">
							</ui-select-match>
							<ui-select-choices repeat="city.name as city in ctrl.cities | propsFilter: {name: $select.search}">
							{{--  <div ng-bind-html="city.name | highlight: $select.search"></div>  --}}
							<small>
								<% city.name %>
							</small>
							</ui-select-choices>
						</ui-select>
						{{--  <i class="fa fa-map-marker" aria-hidden="true"></i>
						@if(Session::has('city'))
						<input class="form-control dropdown-toggle" id="nametp" name="cname" placeholder="City" data-toggle="dropdown" value="{{Session::get('city')}}">
						@else
						<input class="form-control dropdown-toggle" id="nametp" name="cname" placeholder="City" data-toggle="dropdown">
						@endif
						<ul class="dropdown-menu">
							@foreach($cities as $c)
							<li><p id="loca">{{$c->name}}</p></li>
							@endforeach
						</ul>  --}}
					</div>
					<div class="form-group col-sm-3 col-md-3 col-lg-2">
						<input type="submit" class="btn btn-default btn-search" value="Search" >
					</div>
				</form>
