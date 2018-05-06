$(document).ready(function() {
	$('.review-form').validate({
		rules: {
			title: {
				required:true
			},
			like: {
				required:true
			},
			unlike: {
				required:true
			},
		},
		messages: {
			title: {
				required:"<i class='fa fa-times' aria-hidden='true'></i>Thêm nội dung"
			},
			like: {
				required:"<i class='fa fa-times' aria-hidden='true'></i>Thêm nội dung"
			},
			unlike: {
				required:"<i class='fa fa-times' aria-hidden='true'></i>Thêm nội dung"
			}
		},
		submitHandler:function(form) {
			form.submit();
		}
	});
	$('#email').keyup(function() {
		$('.errorLogin').hide();
	});
	$('#password').keyup(function() {
		$('.errorLogin').hide();
	});
	$('#frmLogin').validate({
            rules:{
                  email: {
                        required:true,
                        email:true,
                  },
                  password: {
                        required:true,
                  }
            },
            messages: {
                  email: {
                        required: "Email không được để trống",
                        email: "Email không đúng định dạng"
                  },
                  password: {
                        required:"Mật khẩu không được để trống"
                  }
            },
            submitHandler:function() {
            	$.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });
	            $.ajax({
	            	type:'post',
	            	url:'login-modal',
	            	data:{
	            		'email':$('#email').val(),
	            		'password':$('#password').val()
	            	},
	            	success: function(data) {
	            		if (data.error == true) {
	            			$('.errorLogin').show().text(data.message);
	            			$('#password').val("");
	            		} else {
	            			 location.reload();
	            		}
	            	}
	            });
            }
      });
	$('#frmRegister').validate({
            rules: {
				name: {
					required: true,
				},
				email: {
					required: true,
					email: true,
				},
				password: {
					required: true,
					minlength: 6,
				},
				repeatPassword: {
					required: true,
					equalTo: "#password"
				}
            },
            messages: {
            	name: {
            		required: "Vui lòng nhập tên của bạn"
            	},
              	email: {
					required: "Email không được để trống",
					email: "Email không đúng định dạng"
              	},
              	password: {
					required:"Mật khẩu không được để trống",
					minlength: "Mật khẩu ít nhất 6 ký tự"
				},
				repeatPassword: {
					required: "Vui lòng xác nhận mật khẩu",
					equalTo: "Xác nhận mật khẩu không đúng"
				}
            },
            submitHandler:function() {
            	$.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });
	            $.ajax({
	            	type:'post',
	            	url:'/dang-ky',
	            	data: { 
						'email': $('#email').val(),
						'password': $('#password').val(),
						'name': $('#name').val()
					},
	            	success: function(data) {
						$('.alert').hide();
	            		if(data.error) {
	            			$('.alert-danger').css({
								'display': 'block',
							});
	            			$('.errRegister').show().text(data.message);
	            			$('#email').val("");
	            		} else {
							$('.alert-success').css({
								'display': 'block',
							});
							$('.successRegister').show().text(data.message);
							setTimeout(function() {
								window.location.href = location.protocol + "//" + location.host;
							}, 1000);
	            		}
	            	}
	            });
            }
      });
	$('#formApply').validate({
		rules:{
			fullname: {
				required: true,
			},
			email: {
				required: true,
				email: true,
			},
			new_cv: {
				required: true,
				extension: "pdf|doc|docx",
			}
		},
		messages: {
			fullname: {
				required:"Vui lòng nhập tên của bạn",
			},
			email: {
				required:"Vui lòng nhập email",
				email:"Email không đúng định dạng",
			},
			new_cv: {
				required:"Vui lòng đính kèm CV",
				extension:"Vui lòng đính kèm file .doc .docx hoặc .pdf"
			}
		},
		submitHandler:function() {

		}
	});
	$('#frmContact').validate({
		rules: {
			email: {
				required: true,
				email: true,
			},
			name: {
				required: true,
			},
			subtitle: {
				required: true,
			},
			content: {
				required: true
			}
		},
		messages:{
			email:{
				required:"Vui lòng nhập email",
				email:"Email không đúng định dạng",
			},
			name:{
				required:"Vui lòng nhập tên",
			},
			subtitle:{
				required:"Vui lòng nhập tiêu đề",
			},
			content:{
				required:"Vui lòng nhập nội dung",
			}
		},
		submitHandler: function(){
		}
	});
});