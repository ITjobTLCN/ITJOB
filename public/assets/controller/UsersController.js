app.controller('UsersController',function($scope,$http){
	$http({
		method:'GET',
		url:'profile-user',
	}).then(function(response){
		//console.log(response);
		$scope.users=response.data;
	},function(error){
		console.log(error,'can not get data');
	});
	$scope.saveNewEmail=function(){
		var newEmail=$scope.users.email;
		$http({
			method:'POST',
			url:'add',
			params:{'newEmail':newEmail},
			headers: {'Content-type':'application/x-www-form-urlencoded'}
		}).then(function(response){
			alert("Cập nhật email thành công");
			location.reload();
		},function(error){
			console.log(error,'can not get data')
		});
	},
	$scope.saveProfile=function(){
		var data=$.param($scope.users);
		$http({
			method:'POST',
			url:'editProfile',
			data:data,
			headers:{'Content-type':'application/x-www-form-urlencoded'}
		}).then(function(response){
			alert('Cập nhật thành công thông tin cá nhân');
			location.reload();
		},function(error){
			console.log(error,'can not get data');
		});
	}
});