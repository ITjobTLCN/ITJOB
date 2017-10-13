$(document).ready(function(){
	$('#result-search-company').hide();
	$('#result-search-job').hide();

	$('#company_name').keyup(function(){
		var key=$(this).val();
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url:'search-company',
			data:{
				'key':key,
			},
			success : function(data){
				$('#result-search-company').show();
				$('ul.search-company').show().html(data);		
				if(key==""){
					$('#result-search-company').hide();
				}
			}
		});
	});
	var count1=0;
	var count2=0;
	//see more companies hiring now
	$('#see-more-hiring').click(function(){
		count1+=6;
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url: 'more-hiring-companies',
			data: {'count1':count1},
			success:function(data){
				$('.more-hiring').append(data);
			}

		});
	});
	//see more most followed companies
	$('#see-more-most-followed').click(function(){
		count2+=6;
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url: 'more-most-followed-companies',
			data: {'count2':count2},
			success:function(data){
				$('.more-most-followed').append(data);
			}
		});
	});
	$('#keyword-skill').keyup(function(){
		var key=$(this).val();
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type: 'get',
			url:'search-job',
			data:{'key':key},
			success:function(data){
				$('#result-search-job').show();
				$('ul.search-job').show().html(data);		
				if(key==""){
					$('#result-search-job').hide();
				}
			}
		});
	});
});