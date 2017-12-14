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
	$('#email').keyup(function(){
		$('.errorLogin').hide();
	});
	$('#password').keyup(function(){
		$('.errorLogin').hide();
	});
	$('#frmLogin').validate({
            rules:{
                  email:{
                        required:true,
                        email:true,
                  },
                  password:{
                        required:true,
                  }
            },
            messages:{
                  email:{
                        required: "Email không được để trống",
                        email: "Email không đúng định dạng"
                  },
                  password:{
                        required:"Mật khẩu không được để trống"
                  }
            },
            submitHandler:function(){
            	$.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });
	            $.ajax({
	            	type:'post',
	            	url:'login-modal',
	            	data:{'email':$('#email').val(),'password':$('#password').val()},
	            	success:function(data){
	            		if(data.error==true){
	            			$('.error').hide();
	            			$('.errorLogin').show().text(data.message);
	            		}else{
	            			location.reload();
	            		}
	            	}
	            });
            }
      });
});