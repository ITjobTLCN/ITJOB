app.controller('EmpController',function($scope,$http){
	$http.get('admin/ngemps').then(function(response){
		console.log(response);
		$scope.emps = response.data.emps;
		$scope.cities = response.data.cities;
	},function(error){
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
				$http({
					method:'post',
					url:'admin/ngcreateemp',
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
					alert("Can't add data");
				});
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

	}

	/*sort-num of raw in table*/
	$scope.showitems = '3';
	$scope.sort = function(type){
		$scope.sortType = type;
		$scope.sortReverse = !$scope.sortReverse;
	}
});