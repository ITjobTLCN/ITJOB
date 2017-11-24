$(document).ready(function(){
	$('.review-form').validate({
		
		rules:{
			title:{
				required:true
			},
			like:{
				required:true
			},
			unlike:{
				required:true
			},
		},
		messages:{
			title:{
				required:"<i class='fa fa-times' aria-hidden='true'></i>Thêm nội dung"
			},
			like:{
				required:"<i class='fa fa-times' aria-hidden='true'></i>Thêm nội dung"
			},
			unlike:{
				required:"<i class='fa fa-times' aria-hidden='true'></i>Thêm nội dung"
			}
		},
		submitHandler:function(form){
			form.submit();
		}
	});
});