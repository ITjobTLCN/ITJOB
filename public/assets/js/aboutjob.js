$(document).ready(function(){
	$('p#loca').click(function(){
		$loca=$(this).text();
		$('#nametp').val($loca);
	});
      $(document).on('click','div#followJob',function(){
            var job_id=$(this).attr('job_id');
            var emp_id=$(this).attr('emp_id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                  type:'get',
                  url:'follow-job',
                  data:{job_id:job_id,com_id:emp_id},
                  success:function(response){
                        console.log(response);
                        if(response=="add"){
                              $('.follow'+job_id).html('<i class="fa fa-heart" aria-hidden="true" data-toggle="tooltip" title="UnFollow"></i>');
                        }else{
                              $('.follow'+job_id).html('<i class="fa fa-heart-o" aria-hidden="true" data-toggle="tooltip" title="Follow"></i>');
                        }
                  }
            });
      });
	$(document).ajaxComplete(function() {
 		$("[rel=popover]").popover({ 
 			trigger: "manual" , 
            html: true, 
            placement: "bottom",
            content: '<span>You must <a href="" data-toggle="modal" data-target="#loginModal">Login </a>to do this</span>',
            animation:false
 		})
 		.on("mouseenter", function () {
            var _this = this;
            $(this).popover("show");
            $(".popover").on("mouseleave", function () {
                  $(_this).popover('hide');
            });
      }).on("mouseleave", function () {
            var _this = this;
            setTimeout(function () {
                  if (!$(".popover:hover").length) {
                        $(_this).popover("hide");
                  }
            }, 100);
      });
	});
	
});