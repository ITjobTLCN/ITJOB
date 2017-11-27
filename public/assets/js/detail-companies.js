$(document).ready(function(){
	$('.followed i').css({
		'display':'none',
	});
	$('.list-job-hiring .fa-arrow-up').css({
		'display':'none',
	});
	$('.loading').css({
		'display':'none',
	});
	var dem=0;
	$('#up-down').click(function(){
		$("i", this).toggleClass("fa fa-arrow-up fa fa-arrow-down");
		$('.loading').css({
			'display':'block',
		});
		dem++;
		if(dem>0){
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			$.ajax({
				type:'get',
				url:'list-jobs-company',
				cache:true,
				data:{
					'dem':0,
					'emp_id':$('#company_id').val(),
				},
				success:function(data){
					$('.result-job-company').html(data);
				}
			});
		}
	});
	//see-more jobs in company
	var dems=0;
	$('#see-more-job-company').click(function(){
		$('.loading').css({
			'display':'block',
		});
		dems+=10;
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url:'list-jobs-company',
			data:{
				'dem':dems,
				'emp_id':$('#company_id').val()
			},
			success:function(data){
				$('.result-job-company').append(data);
			}
		});
	});
	$('#openLoginModal').click(function(e){
        $('#loginModal').modal();
    });
	//flowed companies
	$('.followed').click(function(){
		var emp_id=$('#emp_id').val();
		$('.followed i').css({
			'display':'inline-block',
		});
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url:'companies/follow-company',
			data:{
				emp_id:emp_id,
			},
			success : function(data){
				
				$('.followed').html(data);
			}
		});
	});

	//chart recommend of users
    $('.chart').percentcircle({
        animate : true,
        diameter : 100,
        guage: 2,
        coverBg: '#fff',
        bgColor: '#efefef',
        fillColor: '#5c93c8',
        percentSize: '20px',
        percentWeight: 'normal'
    });

	//see more reviews about companies
	var cReview=0;
	$('#see-more__reviews').click(function(e){
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url:'see-more-reviews',
			data:{
				'cReview':cReview+=10,
				'emp_id':$('#emp_id').val()
			},
			success:function(data){
				$('.result-reviews').append(data);
			}
		});
		e.preventDefault();
	});
	
});
$(document).ajaxComplete(function(){
	$('.loading').css({
		'display':'none',
	});
	$('.followed i').css({
		'display':'none',
	});
	$('.salary-job').click(function(e){
		$('#loginModal').modal();
		e.preventDefault();
	});
});