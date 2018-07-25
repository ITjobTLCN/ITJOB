app.controller('HomeController', function($scope, $http, toaster) {
	$scope.loadReg = function() {
		$http.get('ngload/register-employer').then(function(response) {
			console.info('initInfo', response.data);
			$scope.cities = response.data.cities;
			$scope.emps = response.data.emps;
		}, function(error) {
			toaster.pop('error', 'ERROR', 'cannot get data from server');
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
			if (response.data.status) {
				toaster.pop('success', 'Success', response.data.message);
				$scope.reset();
			} else {
				toaster.pop('warning', 'Warning', response.data.message);
			}

		}, function(error) {
			toaster.pop('error', 'ERROR', 'cannot post data to server');
		});
	}
});