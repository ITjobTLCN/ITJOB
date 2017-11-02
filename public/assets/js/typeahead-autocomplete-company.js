$(document).ready(function(){
		var results=new Bloodhound({
			datumTokenizer:Bloodhound.tokenizers.obj.whitespace('com_name'),
			queryTokenizer:Bloodhound.tokenizers.whitespace,
			remote:{
				url:"search-companies?search={query}",
				wildcard:"{query}"
			}
		});
		results.initialize();
		$('#company_name').typeahead({
			hint:true,
			highlight:true,
			minLength:2,
			maxItem:7.
		},
		{
			name: 'companies',
			displayKey: 'com_name',
			source: results.ttAdapter(),
			templates:{
				empty:function(){
					
				},
				suggestion:function(companies){
					var string='<a class="tt-suggestion-link" target="_blank" href="companies/' + companies.com_alias +'">'+companies.com_name+'</a></br>';
					return string;
				}
			}
		});
	});