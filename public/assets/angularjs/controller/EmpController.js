app.controller('EmpController', function ($scope, $http, Constant) {
	$http.get('admin/ngemps').then(function(response){
		console.log(response);
		$scope.emps = response.data.emps;
		$scope.constant = Constant;
		$scope.resetMultiple();
	},function(error){
		alert('ERROR');
	});
	// Get all master & all employer (users)
	$http.get('admin/ngusers').then(function (response) {
		console.log(response);
		$scope.users = response.data.users;
	}, function (error) {
		alert('ERROR');
	});
	// Get all skills employer
	$http.get('admin/ngskills').then(function (response) {
		console.log(response);
		$scope.skills = response.data.skills;
	}, function (error) {
		alert('ERROR');
	});
	// Get all cities employer
	$http.get('admin/ngcities').then(function (response) {
		console.log(response);
		$scope.cities = response.data.cities;
	}, function (error) {
		alert('ERROR');
	});


	$scope.modal = function(state, item){
		$scope.resetMultiple();
		$scope.state = state;
		$scope.employer = item;
		switch(state){
			case Constant.MODAL_ADD:
				$scope.modal_title = Constant.MODAL_ADD_EMPLOYER_TITLE;
				break;
			case Constant.MODAL_EDIT:
				$scope.modal_title = Constant.MODAL_EDIT_EMPLOYER_TITLE;
				$scope.multiple.masters = item.masters;
				$scope.multiple.employees = item.employees;
				$scope.multiple.skills = item.skills;
				$scope.multiple.cities = item.addresses;
				break;
			default:
				break;
		}
		$('#modal-emp').modal('show');
	}

	$scope.save = function(){
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
				alert(response.data.message);
				$scope.emps = response.data.emps;
			} else {
				alert(response.data.message);
			}
		}, function (error) {
			alert("Can't delete data");
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
				alert(response.data.message);
				$scope.emps.splice(0, 0, response.data.emp);
				$('#modal-emp').modal('hide');
			} else {
				$scope.error_message = response.data.errors;
				$('#ng-errors-alert').fadeIn(100).delay(5000).fadeOut(100);
			}
		}, function (error) {
			alert("Can't add data");
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
				alert(response.data.message);
				$scope.emps = response.data.emps;
				$('#modal-emp').modal('hide');
			} else {
				$scope.error_message = response.data.errors;
				$('#ng-errors-alert').fadeIn(100).delay(5000).fadeOut(100);
			}
		}, function (error) {
			alert("Can't edit data");
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
		$scope.multiple = {};
		$scope.multiple.masters = [];
		$scope.multiple.employees = [];
		$scope.multiple.skills = [];
		$scope.multiple.cities = [];
	}


	//Function Get multi
	$scope.getMultiple = function() {
		var master_ids = [];
		var employee_ids = [];
		var skill_ids = [];
		var addresses = [];
		$.each($scope.multiple.masters, function (index, value) {
			master_ids.push({ _id: value._id, name: value.name});
		});
		$.each($scope.multiple.employees, function (index, value) {
			employee_ids.push({ _id: value._id, name: value.name });
		});
		$.each($scope.multiple.skills, function (index, value) {
			skill_ids.push({ _id: value._id, name: value.name });
		});
		$.each($scope.multiple.cities, function (index, value) {
			let detail = $(`#cities_detail_${value._id}`).val();
			let address = { _id: value._id, name: value.name, detail: detail }
			addresses.push(address);
		});
		return {
			masters: master_ids,
			employees: employee_ids,
			skills: skill_ids,
			addresses: addresses
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
				alert(response.data.message);
				$scope.emps = response.data.emps;
			} else {
				alert(response.data.message);
			}
		}, function (error) {
			alert("Can't confirm data");
		});
	}
});
