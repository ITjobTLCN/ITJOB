app.controller('UsersController',function($scope,$http){
	$scope.saveNewEmail=function(){
		var newEmail=$('#newEmail').val();
		$http({
			method:'post',
			url:'users/edit-email',
			params:{'newEmail':newEmail},
			headers: {'Content-type':'application/x-www-form-urlencoded'}
		}).then(function(response){
			
		},function(error){
			console.log(error,'can not get data')
		});
	};
});