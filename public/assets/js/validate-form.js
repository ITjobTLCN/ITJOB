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
	            			$('.errorLogin').show().text(data.message);
	            			$('#password').val("");
	            		}else{
	            			location.reload();
	            		}
	            	}
	            });
            }
      });
	// $('#frmLoginm').validate({
 //            rules:{
 //                  emaill:{
 //                        required:true,
 //                        email:true,
 //                  },
 //                  passwordl:{
 //                        required:true,
 //                  }
 //            },
 //            messages:{
 //                  emaill:{
 //                        required: "Email không được để trống",
 //                        email: "Email không đúng định dạng"
 //                  },
 //                  passwordl:{
 //                        required:"Mật khẩu không được để trống"
 //                  }
 //            },
 //            submitHandler:function(){
 //            	$.ajaxSetup({
	//                 headers: {
	//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	//                 }
	//             });
	//             $.ajax({
	//             	type:'post',
	//             	url:'login-modal',
	//             	data:{'email':$('#emaill').val(),'password':$('#passwordl').val()},
	//             	success:function(data){
	//             		if(data.error==true){
	//             			$('.error').hide();
	//             			$('.errorLogin').show().text(data.message);
	//             		}else{
	//             			location.reload();
	//             		}
	//             	}
	//             });
 //            }
 //      });
	$('#frmRegister').validate({
            rules:{
                  namer:{
                        required:true
                  },
                  emailr:{
                  	required:true,
                  	email:true
                  },
                  passwordr:{
                  	required:true,
                  	minlength: 6
                  }
            },
            messages:{
            	namer:{
            		required: "Vui lòng nhập tên của bạn"
            	},
              	emailr:{
                    required: "Email không được để trống",
                    email: "Email không đúng định dạng"
              	},
              	passwordr:{
                    required:"Mật khẩu không được để trống",
                    minlength: "Mật khẩu ít nhất 6 ký tự"
              	}
            },
            submitHandler:function(){
            	alert($('#passwordr').val());
            	$.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });
	            $.ajax({
	            	type:'post',
	            	url:'register-modal',
	            	data:{'email':$('#emailr').val(),'password':$('#passwordr').val(),'name':$('#namer').val()},
	            	success:function(data){
	            		if(data.error==true){

	            			$('.error').hide();
	            			$('.errorRegister').show().text(data.message);
	            			$('#emailr').val("");
	            		}else{
	            			alert('Đăng ký thành công tài khoản');
	            			location.reload();
	            		}
	            	}
	            });
            }
      });
	$('#formApply').validate({
		rules:{
			fullname:{
				required:true,
			},
			email:{
				required:true,
				email:true,
			},
			new_cv:{
				required:true,
				extension: "pdf|doc|docx",
			}
		},
		messages:{
			fullname:{
				required:"Vui lòng nhập tên của bạn",
			},
			email:{
				required:"Vui lòng nhập email",
				email:"Email không đúng định dạng",
			},
			new_cv:{
				required:"Vui lòng đính kèm CV",
				extension:"Vui lòng đính kèm file .doc .docx hoặc .pdf"
			}
		},
		submitHandler:function(){

		}
	});
});