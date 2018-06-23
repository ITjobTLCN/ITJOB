app.controller('EmpController',function($scope,$http){
	$http.get('admin/ngemps').then(function(response){
		console.log(response);
		$scope.emps = response.data.emps;
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


	$scope.modal = function(state,id){
		$scope.state = state;
		$scope.id = id;
		switch(state){
			case 'add':
				$scope.titleModal = "Create new employers";
				break;
			case 'edit':
				$scope.titleModal = "Edit employers";
				$http.get('admin/ngemp/'+id).then(function(response){
					console.log(response);
					$scope.emp = response.data.emp;
				},function(error){
					alert("Can't get data!");
				});
				break;
			default:
				break;
		}
		$('#modal-emp').modal('show');
	}

	$scope.save = function(state,id){
		var data = $.param($scope.emp);
		switch(state){
			case 'add':

				break;
			case 'edit':
				$http({
					method:'post',
					url:'admin/ngeditemp/'+id,
					data:data,
					headers: {'Content-type':'application/x-www-form-urlencoded'}
				}).then(function(response){
					if(response.data.status==true){
						alert(response.data.message);
						$scope.emps = response.data.emps;
						$('#modal-emp').modal('hide');
					}else{
						$scope.error_message = response.data.errors;
						$('#ng-errors-alert').fadeIn(100).delay(5000).fadeOut(100);
					}
				},function(error){
					alert("Can't edit data");
				});
				break;
			default:
				break;
		}

	}
	$scope.delete =function(id){
		if(confirm('Are you sure delete?')){
			$http.get('admin/ngdeleteemp/'+id).then(function(response){
				if(response.data.status==true){
					alert(response.data.message);
					$scope.emps = response.data.emps;
				}else{
					alert(response.data.message);
				}
			},function(error){
				alert('ERROR')
			});
		}
	}
	$scope.confirm = function(id){
		if(confirm('Are you sure confirm?')){
			$http.get('admin/ngconfirmemp/'+id).then(function(response){
				if(response.data.status==true){
					alert(response.data.message);
					$scope.emps = response.data.emps;
				}else{
					alert(response.data.message);
				}
			},function(error){
				alert('ERROR')
			});
		}
	}
	$scope.deny = function(id){
		if(confirm('Are you sure deny this employer?')){
			$http.get('admin/ngdenyemp/'+id).then(function(response){
				if(response.data.status==true){
					alert(response.data.message);
					$scope.emps = response.data.emps;
				}else{
					alert(response.data.message);
				}
			},function(error){
				alert('ERROR')
			});
		}
	}

	/**
	 * COMMON FUNCTION
	 */
	$scope.create_employer = function (data) {
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
				$scope.emps = response.data.emps;
				$('#modal-emp').modal('hide');
			} else {
				$scope.error_message = response.data.errors;
				$('#ng-errors-alert').fadeIn(100).delay(5000).fadeOut(100);
			}
		}, function (error) {
			alert("Can't add data");
		});
	}


	/*sort-filer-search TABLE with angular */
	$scope.show_items = '3';
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
	$scope.multiple = {};
	$scope.multiple.masters = [];
	$scope.multiple.employees = [];
	$scope.multiple.skills = [];
	$scope.multiple.cities = [];
	$scope.multiple.addresses = [];


	/**
	 * Watch
	 */
	// $scope.multiple.cities.$watch(function () {
	// 	console.log("digest called");
	// });
});
