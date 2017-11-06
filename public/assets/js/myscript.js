$(document).ready(function(){
	$('.list-job-hiring .fa-arrow-up').css({
			'display':'none',
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
	$('#up-down').click(function(){
		$("i", this).toggleClass("fa fa-arrow-up fa fa-arrow-down");
	});
	$dem=0;
	$('#see-more-job-company').click(function(){
		$dem+=6;
		$com_id=$('#company_id').val();
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url:'get-more-job',
			data:{'dem':$dem,'com_id':$com_id},
			success:function(data){
				alert(data);
			}
		});
	});
	$('.clear-all-filter-att').click(function(){
		$('.list-filter-att').css({
            'display':'none'
        });
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
        info_skill=[];
        info_city=[];
		$.ajax({
			type:'get',
			url:'filter-job',
			data:{
				'info_skill':"",'info_city':"",
			},
			success : function(data){
				$('.jb-search__result').html(data);
			}
		});
	});
	$('.followed').click(function(){
		var emp_id=$('#emp_id').val();
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url:'follow-company',
			data:{
				emp_id:emp_id,
			},
			success : function(data){
				$('.followed i').css({
					'display':'inline-block'
				});
				$('.followed').html(data);
			}
		});
	});
	$('#unfollowed').mouseover(function(){
			$(this).text("Unfollow");
		});
	$('#unfollowed').mouseleave(function(){
		$(this).text("Following");
	});	
	$(document).ajaxComplete(function(){
		$('.followed i').css({
			'display':'none'
		});
		$('#unfollowed').mouseover(function(){
			$(this).text("Unfollow");
		});
		$('#unfollowed').mouseleave(function(){
			$(this).text("Following");
		});
	});
});