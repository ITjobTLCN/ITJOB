app.controller('EmpController', function ($scope, $http, Constant, toaster) {
	// Init function
	$scope.init = function () {
		$scope.constant = Constant;
		$scope.loadMasterAssistant();
	}

	$http.get('admin/ngemps').then(function(response) {
		console.log(response);
		$scope.emps = response.data.emps;
		$scope.resetMultiple();
	},function(error){
		toaster.pop('error', 'ERROR', error);
	});

	// Get all master & all employer (users)
	$http.get('admin/ngusers').then(function (response) {
		$scope.users = _.filter(response.data.users, function(o) {
			return o.role_id == Constant.ROLE_CANDIDATE;
		});
		console.log($scope.users);
	}, function (error) {
		toaster.pop('error', 'ERROR', error);
	});

	// Get all skills employer
	$http.get('admin/ngskills').then(function (response) {
		console.log(response);
		$scope.skills = response.data.skills;
	}, function (error) {
		toaster.pop('error', 'ERROR', error);
	});

	// Get all cities employer
	$http.get('admin/ngcities').then(function (response) {
		console.log(response);
		$scope.cities = response.data.cities;
	}, function (error) {
		toaster.pop('error', 'ERROR', error);
	});


	$scope.modal = function(state, item){
		$scope.resetMultiple();
		$scope.state = state;
		$scope.employer = item;
		switch(state) {
			case Constant.MODAL_ADD:
				$scope.modal_title = Constant.MODAL_ADD_EMPLOYER_TITLE;
				break;
			case Constant.MODAL_EDIT:
				$scope.modal_title = Constant.MODAL_EDIT_EMPLOYER_TITLE;
				var arr = [
					'master', 'employee', 'skills', 'address'
				];
				angular.forEach(arr, function($val, $key) {
					if ($val == 'address') {
						$scope.multiple.cities = angular.copy(item[$val]);
					} else {
						_.set($scope.multiple, $val, _.isUndefined(item[$val]) ? [] : item[$val]);
					}
				});
				break;
			default:
				break;
		}

		$('#modal-emp').modal('show');
	}

	$scope.save = function() {
		// Get multiple
		var multiple = $scope.getMultiple();
		var data = $.param(
			{
				employer: $scope.employer,
				multiple: multiple
			}
		);
		switch ($scope.state) {
			case Constant.MODAL_ADD:
				$scope.create_employer(data);
				break;
			case Constant.MODAL_EDIT:
				$scope.edit_employer(data);
				break;
			default:
				break;
		}

	}
	$scope.delete = function(item) {
		var data = $.param(item);
		$http({
			method: 'delete',
			url: 'admin/ngdeleteemp',
			data: data,
			headers: {
				'Content-type': 'application/x-www-form-urlencoded'
			}
		}).then(function (response) {
			if (response.data.status == true) {
				toaster.pop('success', 'Success', response.data.message);
				$scope.emps = response.data.emps;
			} else {
				toaster.pop('error', 'Error', response.data.message);
			}
		}, function (error) {
			toaster.pop('error', 'Error', 'Can not delete data');
		});

	}
	$scope.confirm = function(id, status){
		$scope.changeStatus(id, status);
	}

	/**
	 * COMMON FUNCTION
	 */
	$scope.create_employer = function(data) {
		$http({
			method: 'post',
			url: 'admin/ngcreateemp',
			data: data,
			headers: {
				'Content-type': 'application/x-www-form-urlencoded'
			}
		}).then(function (response) {
			if (response.data.status == true) {
				toaster.pop('success', 'Success', response.data.message);
				$scope.emps.splice(0, 0, response.data.emp);
				$('#modal-emp').modal('hide');
			} else {
				$scope.error_message = response.data.errors;
				$('#ng-errors-alert').fadeIn(100).delay(5000).fadeOut(100);
			}
		}, function (error) {
			toaster.pop('error', 'ERROR', 'Can not add data');
		});
	}
	$scope.edit_employer = function(data) {
		$http({
			method: 'post',
			url: 'admin/ngeditemp',
			data: data,
			headers: { 'Content-type': 'application/x-www-form-urlencoded' }
		}).then(function (response) {
			if (response.data.status == true) {
				toaster.pop('success', 'Success', response.data.message);
				$scope.emps = response.data.emps;
				$('#modal-emp').modal('hide');
			} else {
				$scope.error_message = response.data.errors;
				$('#ng-errors-alert').fadeIn(100).delay(5000).fadeOut(100);
			}
		}, function (error) {
			toaster.pop('error', 'ERROR', 'Can not edit data');
		});
	}


	/*sort-filer-search TABLE with angular */
	$scope.show_items = '5';
	$scope.sort = function (keyname) {
		// Old result
		if (keyname === $scope.sort_type) {
			// Check if sort ASCENDING
			if ($scope.sort_reverse == false) {
				$scope.frezingOrder();
			} else {
				$scope.sort_reverse = false;
			}
		} else {
			$scope.sort_type = keyname;
			$scope.sort_reverse = true;
		}
	}
	// Freezing default to feild: created_at, desc
	$scope.frezingOrder = function () {
		$scope.sort_type = 'created_at';
		$scope.sort_reverse = true;
	}

	/**
	 * Multiple select
	 */
	$scope.resetMultiple = function() {
		$scope.multiple = {
			master : [],
			employee : [],
			skills : [],
			cities : []
		}
	}


	//Function Get multi
	$scope.getMultiple = function() {
		var master_ids = [];
		var employee_ids = [];
		var skill_ids = [];
		var addresses = [];
		$.each($scope.multiple.master, function (index, value) {
			master_ids.push(value);
		});
		$.each($scope.multiple.employee, function (index, value) {
			employee_ids.push(value);
		});
		$.each($scope.multiple.skills, function (index, value) {
			skill_ids.push({ _id: value._id, name: value.name });
		});
		$.each($scope.multiple.cities, function (index, value) {
			let detail = $(`#cities_detail_${value._id}`).val();
			let add = { _id: value._id, name: value.name, detail: detail }
			addresses.push(add);
		});
		return {
			master: master_ids,
			employee: employee_ids,
			skills: skill_ids,
			address: addresses
		}
	}

	// Function get detail address of city
	$scope.getDetailAddress = function() {
		$.each($scope.multiple.cities, function (index, value) {
			let detail = $(`#cities_detail_${value._id}`).val();
			value.push(detail);
		});
		return $scope.multiple.cities;
	}

	//Function change status of employer
	$scope.changeStatus = function(_id, status) {
		var data = $.param({
			_id: _id,
			status: status
		});
		$http({
			method: 'put',
			url: 'admin/ngconfirmemp',
			data: data,
			headers: {
				'Content-type': 'application/x-www-form-urlencoded'
			}
		}).then(function (response) {
			if (response.data.status == true) {
				toaster.pop('success', 'Success', response.data.message);
				$scope.emps = response.data.emps;
			} else {
				toaster.pop('error', 'Error', response.data.message);
			}
		}, function (error) {
			toaster.pop('error', 'Error', 'Can not confirm data');
		});
	}

	/**
	 * List master and Assistant
	 */
	$scope.loadMasterAssistant = function() {
		$http.get('admin/ng_mas_ass').then(function (response) {
			$scope.list_master_assis = response.data.list;
		}, function (error) {
			toaster.pop('error', 'Error', error);
		});
	}

	/**
	 * Activate Master or Assistant
	 */
	$scope.activate = function (id, type) {
		var content = '';
		if (type == Constant.STATUS.ACTIVATE) content = 'activate';
		if (type == Constant.STATUS.DEACTIVATE) content = 'deactivate';
		bootbox.confirm("Are you sure want to " + content + "?", function (result) {
			if(result) {
				var data = $.param({
					id: id,
					type: type
				});
				$http({
					method: 'put',
					url: 'admin/ng_mas_ass',
					data: data,
					headers: {
						'Content-type': 'application/x-www-form-urlencoded'
					}
				}).then(function (response) {
					if (response.data.status == true) {
						toaster.pop('success', 'Success', 'Edited success');
						$scope.list_master_assis = response.data.list;
					}
				}, function (error) {
					toaster.pop('error', 'Error', error);
				});
			}
		});

	}
});
