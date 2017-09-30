app.controller('UsersController',function($scope,$http){
	$scope.saveNewEmail=function(){
		var id=$scope.id;
		var newEmail=$scope.newEmail;
		$http({
			method:'POST',
			url:'add',
			params:{'id':id,'newEmail':newEmail},
			headers: {'Content-type':'application/x-www-form-urlencoded'}
		}).then(function(response){
			//console.log(response);
			location.reload();
		},function(error){
			console.log(error,'can not get data')
		});
	},
	$scope.saveProfile=function(){
		var id=$scope.id;
		var name=$scope.name;
		var desc=$scope.desc;
		$http({
			method:'POST',
			url:'editProfile',
			params:{'id':id,'name':name,'desc':desc},
			headers:{'Content-type':'application/x-www-form-urlencoded'}
		}).then(function(response){
			alert('Cập nhật thành công thông tin cá nhân');
			location.reload();
		},function(error){
			console.log(error,'can not get data');
		});
	}
});