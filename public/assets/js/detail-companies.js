$(document).ready(function(){

	$('.list-job-hiring .fa-arrow-up').css({
		'display':'none',
	});
	$('#up-down').click(function(){
		$("i", this).toggleClass("fa fa-arrow-up fa fa-arrow-down");
	});
	//see-more jobs in company
	var dem=0;
	$('#see-more-job-company').click(function(){
		dem+=6;
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url:'get-more-job',
			data:{
				'dem':dem,
				'com_id':$('#company_id').val()
			},
			success:function(data){
				alert(data);
			}
		});
	});

	//flowed companies
	$('.followed').click(function(){
		var emp_id=$('#emp_id').val();
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
				$('.followed i').css({
					'display':'inline-block'
				});
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