app.controller('UsersController', function($scope, $http) {
	$scope.user = [];
	$scope.hasChangeEmail = false;

	$scope.init = function() {
		$http({
			method: 'get',
			url: 'users'
		}).then(function(response) {
			$scope.user = angular.copy(response.data.data);
		},function(error) {
			console.info(error,'can not get data')
		});
	}

	$scope.saveNewEmail = function() {
		$http({
			method: 'post',
			url: 'users/edit-email',
			params: { 'newEmail' : $scope.user.email },
			headers: {'Content-type': 'application/x-www-form-urlencoded'}
		}).then(function(response) {
			$scope.hasChangeEmail = false;
			alert(response.data.message);
		},function(error) {
			console.info(error, 'can not get data')
		});
	};

	$scope.viewCV = function(cv) {
		return 'http://itjob.local.vn/cv/views/' + cv;
	}

	$scope.changeEmail = function() {
		return $scope.hasChangeEmail = !$scope.hasChangeEmail;
	}
});