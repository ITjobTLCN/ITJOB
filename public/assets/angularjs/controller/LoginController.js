app.controller('LoginController',function($scope,$http,$timeout){
	/*funciton login --using route postlogin -- method: HomeController@postLogin*/
	 $scope.login=function(){
		var data = $.param($scope.user);
		$scope.alert = false;
		$scope.message = "";
		$http({
			method:'POST',
			url:'nglogin',
			data:data,
			headers: {'Content-type':'application/x-www-form-urlencoded'}
		}).then(function(response){
			$('#ng-errors-message').html('');
			console.log(response);
			if(response.data.status==true){	//status = true, đăng nhập thành công
				alert(response.data.message);
				window.location = response.data.url;
			}else{
					$scope.message = response.data.errors;
					$scope.alert = true;
					$timeout(function(){
						$scope.alert = false;
					}, 2000);
					
				// $('#ng-errors-message').html(response.data.errors);
				// $('#ng-errors-alert').fadeIn(100).delay(5000).fadeOut(100);
			}
		},function(error){
			alert('error');
		});
	}
});