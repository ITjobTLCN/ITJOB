$(document).ready(function(){

      //xóa toàn bộ tag dùng để filter job
	$('p#loca').click(function(){
		$loca=$(this).text();
		$('#nametp').val($loca);
	});
      $('i#openLoginModal').click(function(e){
            $('#loginModal').modal();
      });
      $('#keyword').keyup(function() {
            var cKey = $(this).val().length;
            cKey !== 0 ?
                  $('#close i').attr('style', 'display: inline !important')
                  :
                  $('#close i').attr('style', 'display: none !important')
            
            
      });
      $('#close i').click(function() {
            $('#keyword').val("");
            $(this).attr('style', 'display: none !important')
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
                  type: 'get',
                  url: 'follow-job',
                  data: {
                        job_id: job_id,
                        com_id: emp_id
                  },
                  success: function(response) {
                        if(response === "add") {
                              $('.follow'+job_id).html('<i class="fa fa-heart" aria-hidden="true" data-toggle="tooltip" title="UnFollow"></i>');
                        }else{
                              $('.follow'+job_id).html('<i class="fa fa-heart-o" aria-hidden="true" data-toggle="tooltip" title="Follow"></i>');
                        }
                  }
            });
      });
	$(document).ajaxComplete(function() {
            $('i#openLoginModal').click(function(e) {
                  $('#loginModal').modal();
                  e.preventDefault();
            });
 	
      });
});