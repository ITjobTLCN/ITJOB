$(document).ready(function(){
		var results=new Bloodhound({
			datumTokenizer:Bloodhound.tokenizers.obj.whitespace('job_name'),
			queryTokenizer:Bloodhound.tokenizers.whitespace,
			remote:{
				url:"search-job?search={query}",
				wildcard:"{query}"
			}
		});
		results.initialize();
		$('#keyword').typeahead({
			hint:true,
			highlight:true,
			minLength:2,
			maxItem:7.
		},
		{
			name: 'jobs',
			displayKey: 'job_name',
			source: results.ttAdapter(),
			templates:{
				empty:function(){
					
				},
				suggestion:function(jobs){
					var string='<a class="tt-suggestion-link" href="it-job/' + jobs.job_alias +'">'+jobs.job_name+'</a></br>';
					return string;
				}
			}
		});
	});