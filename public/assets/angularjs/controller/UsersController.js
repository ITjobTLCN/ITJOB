app.controller('UsersController', function ($scope, $http, Constant, toaster) {
	/*function load default data -- using getadminusers -- method: AdminController@getUsers*/
	$http({
		method:'GET',
		url:'admin/ngusers'
	}).then(function(response){
		$scope.users = response.data.users;
		$scope.constant = Constant;
	},function(error){
		toaster.pop('error', 'ERROR', error.message);
	});



	/*open modal to edit/create  --using route getuser ----method AdminController@ngGetUser*/
	$scope.modal = function(state, item) {
		console.log(state);
		$scope.state = state;
		$scope.user = item;

		$scope.change = true;
		$('#block-changepassword').show();

		// Load data of roles
		$scope.roles = $scope.load_roles();

		switch(state) {
			case Constant.MODAL_ADD:
				$scope.user_modal = Constant.MODAL_ADD_USER_TITLE;
				break;
			case Constant.MODAL_EDIT:
				$scope.user_modal = Constant.MODAL_EDIT_USER_TITLE;
				$scope.change = false;
				/*function toggle to change password-------------*/
				$scope.toggleChange = function(){
					$scope.change=!$scope.change;
					$('#password').val('');
					$('#repassword').val('');
					$scope.frmCreate.password.$setPristine();
					$scope.frmCreate.repassword.$setPristine();
					if(!$scope.change){
						$scope.frmCreate.password.$setValidity('minlength',true);
						$scope.frmCreate.repassword.$setValidity('minlength',true);
					}else{
						$scope.frmCreate.password.$setValidity('minlength',false);
						$scope.frmCreate.repassword.$setValidity('minlength',false);
					}
				}
				break;
			default:
				break;
		}
		$('#modal-create-user').modal('show');
	}

	/*function Save from modal add/edit -----using route ---method:  */
	 // Save data
	 $scope.save = function () {
	 	$scope.errors = undefined;
	 	var data = {};
	 	// if ($scope.user != undefined) {
	 	// 	($scope.created_at) ? delete $scope.created_at: null;
	 	// 	($scope.updated_at) ? delete $scope.updated_at: null;
	 	// 	data = $.param($scope.role);
	 	// }
	 	//delele some scope variables
		data = $.param($scope.user);
	 	console.log(data);
	 	switch ($scope.state) {
	 		case Constant.MODAL_ADD:
	 			$scope.create_user(data);
	 			break;
	 		case Constant.MODAL_EDIT:
	 			$scope.edit_user(data);
	 			break;
	 		default:
	 			break;
	 	}
	 }

	/*function delete user was chosen -----using route: admin/ngdelete/{id}-----method:ngGetDeleteUser*/
	 $scope.delete = function(id) {
		console.log(id);
		$scope.errors_delete = undefined;
        data = $.param({'_id': id});
		$scope.delete_user(data);
	}

	/*sort-filer-search TABLE with angular */
	$scope.showitems = '5';
	$scope.sort = function(keyname) {
		// Old result
		if (keyname === $scope.sortType) {
			// Check if sort ASCENDING
			if ($scope.sortReverse == false) {
				$scope.frezingOrder();
			} else {
				$scope.sortReverse = false;
			}
		} else {
			$scope.sortType = keyname;
			$scope.sortReverse = true;
		}
	}

	// Freezing default to feild: created_at, desc
	$scope.frezingOrder = function() {
		$scope.sortType = 'created_at';
		$scope.sortReverse = true;
	}



	/**
	 * COMMON FUNCTION
	 */
	$scope.create_user = function (data) {
		$http({
			method: "post",
			url: "admin/ngcreateuser",
			data: data,
			headers: {
				'Content-type': 'application/x-www-form-urlencoded'
			}
		}).then(function (response) {
			if (response.data.status == true) {
				toaster.pop('success', 'Success', response.data.message);
				//push user to scope user
				$scope.users.splice(0, 0, response.data.user);
				//close modal
				$('#modal-create-user').modal('hide');
			} else {
				$scope.error_message = response.data.errors;
				$('#ng-errors-alert').fadeIn(100).delay(5000).fadeOut(100);
			}
		}, function (error) {
			toaster.pop('error', 'ERROR', error);
		});
	}

	$scope.edit_user = function(data) {
        $http({
        	method: "post",
        	url: "admin/ngedituser",
        	data: data,
        	headers: {
        		'Content-type': 'application/x-www-form-urlencoded'
        	}
        }).then(function (response) {
        	if (response.data.status == true) {
        		toaster.pop('success', 'Success', response.data.message);

        		// Update list user
        		$scope.users = response.data.users;
        		//close modal
        		$('#modal-create-user').modal('hide');
        	} else {
        		$scope.error_message = response.data.errors;
        		$('#ng-errors-alert').fadeIn(100).delay(5000).fadeOut(100);
        	}
        }, function (error) {
        	toaster.pop('error', 'ERROR', error);
        });
	}

	$scope.delete_user = function (data) {
		if (!confirm("Delete this user?")) {
			return;
		}
		$http({
			method: "DELETE",
			url: 'admin/ngdeleteuser',
			data: data,
			headers: {
				'Content-type': 'application/x-www-form-urlencoded'
			}
		}).then(function (response) {
			if (response.data.status == true) {
				toaster.pop('success', 'Success', response.data.message);
				//delete then load list user send to scope user
				$scope.users = response.data.users;
			} else {
				$scope.errors_delete = response.data.errors;
				$timeout(function () {
					$scope.errors_delete = undefined;
				}, 5000);
			}
		}, function (error) {
			toaster.pop('error', 'ERROR', error);
		});
	}

	$scope.load_roles = function() {
		var roles = {};
		// Load data of roles
		$http({
			method: 'get',
			url: 'admin/ngroles',
		}).then(function (response) {
			$scope.roles = response.data.roles;
		}, function (error) {
			toaster.pop('error', 'ERROR', error);
		});

		return roles;
	}

});
