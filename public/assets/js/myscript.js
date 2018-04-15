$(document).ready(function(){
	
	$('.active i').css({
		'color':'#365899'
	});
	$('.loading, #result-more-companies').css({
		'display':'none',
	});
	var cNormal=0;
	$('#see-more-companies').click(function(){
		$('.loading').css({
			'display':'block',
		});
		cNormal+=10;
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			type:'get',
			url: 'more-companies',
			data: {'cNormal':cNormal},
			success:function(data){
				if(data.length != 0){
					$('#result-more-companies').css({
						'display':'block',
					});
					$('#more-companies').append(data);
				}
			}
		});
	});
	
	
	//add star reviews companies
	var cStar=1;
	var temp=['phân vân','Cần cải thiện nhiều','Tốt','Rất tốt','Tuyệt vời'];
	$('#add-star').click(function(){
		if(cStar<5){
			$('#sub-star').removeClass('disabled');
			cStar++;
			$('#type-review').text(temp[cStar]);
			
			$('#cStar').val(cStar);
			$('.star-review').append('<a href="" id="star'+cStar+'"><i class="fa fa-star" aria-hidden="true"></i></a>');
			if(cStar==5){
				$(this).addClass('disabled');
			}
		}
	});
	//sub star reviews companies
	$('#sub-star').click(function(){
		if(cStar>1){
			$('#add-star').removeClass('disabled');
			$('a#star'+cStar).remove();
			cStar--;
			$('#type-review').text(temp[cStar-1]);
			$('#cStar').val(cStar);
			if(cStar==1){
				$(this).addClass('disabled');
			}
		}
	});
	//recommend to friends
	$('#yes').click(function(){
		$('#recommend').val(1);
		$('.yes i').css({
			'color':'#365899',
		});
		$('.no i').css({
			'color':'grey',
		});
	});
	$('#no').click(function(){
		$('#recommend').val(0);
		$('.no i').css({
			'color':'red',
		});
		$('.yes i').css({
			'color':'grey',
		});
	});

	$('#clickModalLogin').click(function(e){
		$('#modalRegister').modal('hide');
		$('#loginModal').modal('show');

		e.preventDefault();
	});
	$('#clickModalRegister').click(function(e){
		$('#loginModal').modal('hide');
		$('#modalRegister').modal('show');
		e.preventDefault();
	});

});
$(document).ajaxComplete(function(){
	$('.loading').css({
		'display':'none',
	});
});
function markNotificationAsRead(countNoti){
	if(countNoti!='0'){
		$.get('markAsRead');
	}
}
