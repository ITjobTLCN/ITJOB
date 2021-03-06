$(document).ready(function() {
	//followed
    $('.followed .unfollowed').mouseover(function() {
        $(this).text("Un Followed");
    });
    $('.unfollowed').mouseleave(function(){
        $(this).text("Following");
    });
	$('.followed i').css({
		'display':'none',
	});
	$('.list-job-hiring .fa-arrow-up').css({
		'display':'none',
	});
	$('#see-jobs-company').click(function() {
		$("i", this).toggleClass("fa fa-arrow-up fa fa-arrow-down");
		$('.loading').css({
			'display':'block',
		});
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type: 'get',
			url: 'more-jobs-company',
			cache: true,
			data: {
				'offset': 0,
				'emp_id': $('#company_id').val(),
			},
			success:function(data) {
				$('.result-job-company').html(data);
			}
		});
	});
	//see-more jobs in company
	var offset = 0;
	$('#see-more-job-company').click(function() {
		$('.loading').css({
			'display':'block',
		});
		offset += 20;
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type: 'get',
			url: 'more-jobs-company',
			data:{
				'offset': offset,
				'emp_id': $('#company_id').val()
			},
			success:function(data) {
				$('.result-job-company').append(data);
			}
		});
	});
	$('a#openLoginModal').click(function(e) {
		e.preventDefault();
        $('#loginModal').modal();
    });
	//flowed companies
	$('.followed #followed').click(function(e) {
		e.preventDefault();
		$('.followed i').css({
			'display': 'inline-block',
		});
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url:'companies/follow-company',
			data: {
				emp_id: $('#emp_id').val(),
			},
			success : function(data) {
				console.log(data);
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
		$('.loading').css({
			'display':'block',
		});
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
	$('.unfollowed').mouseover(function() {
        $(this).text("Un Followed");
    });
    $('.unfollowed').mouseleave(function(){
        $(this).text("Following");
    });
	$('.followed #followed').click(function(e) {
		e.preventDefault();
		$('.followed i').css({
			'display': 'inline-block',
		});
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url:'companies/follow-company',
			data: {
				emp_id: $('#emp_id').val(),
			},
			success : function(data) {
				console.log(data);
				$('.followed').html(data);
			}
		});
	});
});