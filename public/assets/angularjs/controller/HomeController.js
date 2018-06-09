app.controller('HomeController', function($scope, $http) {
	$scope.loadReg = function() {
		$http.get('ngload/register-employer').then(function(response) {
			console.log(response.data);
			$scope.cities = response.data.cities;
			$scope.emps = response.data.emps;
		},function(error) {
			console.log('erros', 'cannot get data from server');
		});
		$scope.new = true;
	}
	$scope.reset = function() {
		$scope.curemp = null;
		$scope.new = true;
	}

	$scope.submitReg = function() {
		var req = {
			 method: 'POST',
			 url: 'register/employer',
			 headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			 data: $.param($scope.curemp),
		};
		$http(req).then(function(response) {
			console.log(response.data);
			if (response.data.status) {
				$('#reg-message-result').css({
					'display' : 'block'
				});
				$scope.message = response.data.message;
				$scope.editable = false;
				$scope.reset();
			} else {
				alert('WARNING ' + response.data.message);
				$scope.reset();
			}
			//location.reload();
		}, function(error) {
			console.log('erros', 'cannot post data to server');
		});
	}
});