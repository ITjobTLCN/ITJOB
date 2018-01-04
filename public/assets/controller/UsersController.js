app.controller('UsersController',function($scope,$http){
	$scope.saveNewEmail=function(){
		var newEmail=$('#newEmail').val();
		$http({
			method:'post',
			url:'profile/edit-email',
			params:{'newEmail':newEmail},
			headers: {'Content-type':'application/x-www-form-urlencoded'}
		}).then(function(response){
			alert("Cập nhật email thành công");
			location.reload();
		},function(error){
			console.log(error,'can not get data')
		});
	};
});