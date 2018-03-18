$(document).ready(function() {
		var lstCompany = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('com_name'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: "search-companies?search={query}",
				wildcard: "{query}"
			}
		});
		var lstJobs = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('result_name'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url:"search-job?search={query}",
				wildcard:"{query}"
			}
		});
		lstCompany.initialize();
		lstJobs.initialize();
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
		$('#keyword').typeahead({
			hint:true,
			highlight:true,
			minLength:2,
			maxItem:7.
		},
		{
			name: 'jobs',
			displayKey: 'result_name',
			source: lstJobs.ttAdapter(),
			templates:{
				empty:function(){
					
				},
				suggestion:function(jobs) {
					var result = '<li class="typeahead-search"><span>' + jobs.result_name +'</span></li>';
					return result;
				}
			}
		});
	});