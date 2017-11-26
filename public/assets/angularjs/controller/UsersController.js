app.controller('UsersController',function($scope,$http){
	/*function load default data -- using getadminusers -- method: AdminController@getUsers*/
	$http({
		method:'GET',
		url:'admin/ngusers'
	}).then(function(response){
		// console.log(response);
		$scope.users = response.data.users;
	},function(error){
		alert('500 (Internal Server Error)');
	});

	

	/*open modal to edit/create  --using route getuser ----method AdminController@ngGetUser*/
	 $scope.modal = function(state,id){
		$scope.change = true;
		$('#block-changepassword').show();
		$scope.state = state;
		$scope.id = id;

		//send data of role
		$http({
			method:'get',
			url:'admin/ngroles',
		}).then(function(response){
			$scope.roles = response.data.roles;
		},function(error){
			alert('error');
		});

		switch(state){
			case 'add':
				// $scope.user = "";
				$scope.titleModal="Create a account";
				break;
			case 'edit':
				$scope.change =false;
				$scope.titleModal="Edit account";
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
				$http({
					method:'get',
					url:'admin/nguser/'+id,
				}).then(function(response){
					console.log(response.data);
					$scope.user = response.data.user;
				},function(error){
					alert('error');
				});
				break;
			default:
				break;
		}
		$('#modal-create-user').modal('show');
	}

	/*function Save from modal add/edit -----using route ---method:  */
	 $scope.save  = function(state,id){
		var data = $.param($scope.user);
		$scope.error_message = "";
		switch(state){
			case 'add':
				$http({
					method:"post",
					url: "admin/ngcreateuser",
					data:data,
					headers: {'Content-type':'application/x-www-form-urlencoded'}
				}).then(function(response){
					if(response.data.status==true){
						alert(response.data.message);
						//push user to scope user 
						$scope.users.push(response.data.item);
						//close modal
						$('#modal-create-user').modal('hide');
					}else{
						$scope.error_message = response.data.errors;
						$('#ng-errors-alert').fadeIn(100).delay(5000).fadeOut(100);
					}
				},function(error){
					alert(error);
				});
				break;
			case 'edit':
				$http({
					method:"post",
					url: "admin/ngedituser/"+id,
					data:data,
					headers: {'Content-type':'application/x-www-form-urlencoded'}
				}).then(function(response){
					if(response.data.status==true){
						alert(response.data.message);	
						
						//update list user
						$scope.users = response.data.items;
						//close modal
						$('#modal-create-user').modal('hide');
					}else{
						$scope.error_message = response.data.errors;
						$('#ng-errors-alert').fadeIn(100).delay(5000).fadeOut(100);
					}
				},function(error){
					alert(error);
				});
				break;
			default:
				break;
		}
	}

	/*function delete user was chosen -----using route: admin/ngdelete/{id}-----method:ngGetDeleteUser*/
	 $scope.deleteUser = function(id){
		if(confirm('Delete this row?')){
			$http({
			method:'get',
			url:'admin/ngdeleteuser/'+id,
			}).then(function(response){
				if(response.data.status==true){
					alert(response.data.message);
					//delete then load list user send to scope user
					$scope.users = response.data.items;		
				}else{
					alert(response.data.message);
				}
			},function(error){
				alert('error');
			});
		}
	}

	/*sort-filer-search TABLE with angular */
	$scope.showitems = '3';
	$scope.sort = function(keyname){
		$scope.sortType = keyname;
		$scope.sortReverse = !$scope.sortReverse;
	}

});