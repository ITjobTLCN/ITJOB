$(document).ready(function(){
	
	$('.active i').css({
		'color':'#365899'
	});
	
	var count1=0;
	var count2=0;
	//see more companies hiring now
	$('#see-more-hiring').click(function(){
		alert("clicked");
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
	$('#see-more-most-followed').click(function(e){
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
});