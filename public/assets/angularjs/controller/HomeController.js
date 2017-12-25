app.controller('HomeController',function($scope,$http){
	$scope.loadReg = function(){
		$http.get('ngloadreg').then(function(response){
			console.log(response.data);
			$scope.cities = response.data.cities;
			$scope.emps = response.data.emps;
		},function(error){
			alert('ERROR');
		});
		$scope.new = true;
	}
	$scope.reset = function(){
		$scope.curemp = null;
		$scope.new = true;
	}

	$scope.submitReg = function(){
		$http({
			url:'registeremp',
			method: 'post',
			data: $.param($scope.curemp),
			headers: {'Content-type':'application/x-www-form-urlencoded'}
		}).then(function(response){
			console.log(response.data);
			if(response.data.status==true){
				$scope.editable = false;
			}
			alert(response.data.message);
		},function(error){
			alert('ERROR');
		});
	}
});