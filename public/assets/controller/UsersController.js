app.controller('UsersController', function($scope, $http, toaster) {
	$scope.user = [];
	$scope.hasChangeEmail = false;
	$scope.fullname = "";

	$scope.init = function() {
		$http({
			method: 'get',
			url: 'users'
		}).then(function(response) {
			$scope.user = angular.copy(response.data.data);
			$scope.fullname = $scope.user.name;
		},function(error) {
			toaster.pop('error', 'ERROR', 'can not get data');
		});
	}

	$scope.saveNewEmail = function() {
		$http({
			method: 'post',
			url: 'users/edit-email',
			params: { 'newEmail' : $('#newEmail').val() },
			headers: {'Content-type': 'application/x-www-form-urlencoded'}
		}).then(function(response) {
			if (!response.data.error) {
				$scope.user.email = response.data.email;
				$scope.hasChangeEmail = false;
				toaster.pop('success', 'Success', response.data.message);
			} else {
				toaster.pop('warning', 'WARNING', response.data.message);
			}
		},function(error) {
			toaster.pop('error', 'ERROR', response.data.message);
		});
	};

	$scope.viewCV = function(cv) {
		return 'http://itjob.local.vn/cv/views/' + cv;
	}

	$scope.changeEmail = function() {
		return $scope.hasChangeEmail = !$scope.hasChangeEmail;
	}

	$scope.editProfile = function() {
		$http({
			method: 'post',
			url: 'users/edit-profile',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			data: $.param($scope.user),
		}).then(function(response) {
			if (!response.data.error) {
				$scope.hasChangeEmail = false;
				toaster.pop('success', 'Success', response.data.message);
			} else {
				toaster.pop('warning', 'WARNING', response.data.message);
			}
		},function(error) {
			toaster.pop('error', 'ERROR', response.data.message);
		});
	}
});