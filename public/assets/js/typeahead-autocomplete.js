$(document).ready(function() {
	//search company
		var lstCompany = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('com_name'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: "search-companies?search={query}",
				wildcard: "{query}"
			}
		});
		lstCompany.initialize();
		$('#company_name').typeahead({
			hint: true,
			highlight: true,
			minLength: 2,
			maxItem: 7.
		},
		{
			name: 'companies',
			displayKey: 'com_name',
			source: lstCompany.ttAdapter(),
			templates: {
				empty:function() {
					
				},
				suggestion:function(companies) {
					var string = '<a class="tt-suggestion-link" target="_blank" href="companies/' + companies.com_alias +'">'+ companies.com_name +'</a></br>';
					return string;
				}
			}
		});

		//search jobs
		var lstJobs = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('q'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			limit: 10,
			remote: {
				url:"search-job?search={query}",
				wildcard:"{query}"
			}
		});
		
		lstJobs.initialize();
		
		$('#keyword').typeahead({
			hint: true,
			highlight: true,
			minLength: 2
		},
		{
			name: 'lstJobs',
			displayKey: 'name',
			source: lstJobs.ttAdapter(),
			limit: 20,
			templates: {
				empty:function(){
				},
				suggestion:function(data) {
					return '<li class="typeahead-search"><span>' + data.name +'</span></li>';
				}
			}
		});
	});