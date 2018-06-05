<form class="form-inline" role="form" method="post" action="{{route('seachJob')}}">
    <div class="form-group col-sm-6 col-md-6 col-lg-7 keyword-search">
        <i class="fa fa-search" aria-hidden="true"></i> @if(Session::has('jobname'))
        <input type="text" id="keyword" name="q" class="typeahead form-control" value="{{Session::get('jobname')}}" placeholder="Keyword job title, company..."> @else
        <input type="text" value="" id="keyword" name="q" class="typeahead form-control" placeholder="Keyword job title, company..."> @endif
        <span id="close"><i class="fa fa-times" aria-hidden="true"></i></span>
    </div>
    <div class="form-group col-sm-3 col-md-3 col-lg-3 location-search" ng-controller="SearchController as ctrl">
        <ui-select ng-model="ctrl.city.selected" theme="select2" on-select="onSelected($item)">

            <ui-select-match placeholder="Select location">
                <% $select.selected.name || $select.selected %>
                <input type="hidden" name="calias" value="<% $select.selected.alias || $select.selected %>">
            </ui-select-match>
            <ui-select-choices repeat="city.name as city in ctrl.cities | propsFilter: {name: $select.search}">
                <small>
				    <% city.name %>
			     </small>
            </ui-select-choices>
        </ui-select>
    </div>
    {{ csrf_field() }}
    <div class="form-group col-sm-3 col-md-3 col-lg-2">
        <input type="submit" class="btn btn-default btn-search" value="Search">
    </div>
</form>