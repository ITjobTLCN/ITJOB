app.controller('CompanyController', function($scope,$http){
	$scope.follow=function(emp_id){
		var emp_id=emp_id;
		$http({
			type:'get',
			url:'follow-company',
			params:{emp_id:emp_id}
		}).then(function(response){
			$('.followed').html(response.data);
		},function(error){
			console.log(error,'can not get data');
		});
	}
});
app.directive('bsPopover', function() {
    return function(scope, element, attrs) {
        element.find("a[rel=popover]").popover({ 
            trigger: "manual" , 
            html: true, 
            placement: "left",
            content: '<span class=".pop-content"> You must <a href="#" data-toggle="modal" data-target="#loginModal">Login </a>to do this</span>',
            animation:false})
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
    };
});