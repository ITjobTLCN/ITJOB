app.controller('UserController',function($scope,$http){
	$http({
		method:'GET',
		url:'admin/listUser'
	}).then(function(response){
		$scope.users = response.data;
	},function(error){
		console.log('error');
	});

	$scope.modal = function(state,id){
		
		$scope.state = state;
		$scope.id= id;
		switch(state){
			case 'add':
				$scope.frmTitle ="Thêm User";
				break;
			case 'edit':
				$scope.frmTitle ="Sửa User";
				$http({
					method:'GET',
					url:'admin/getUser/'+id
				}).then(function(response){
					//$scope.status = response.data.status;
					$scope.user = response.data;
				},function(error){
				
				});
				break;
			default:
				break;	
		}

		$("#myModal").modal('show');

	}
	$scope.save = function(state,id){
		switch(state){
			case 'add':
				var url = 'admin/addUser';
				var data = $.param($scope.user);
				$http({
					method: 'POST',
					url:url,
					data:data,
					headers: {'Content-Type':'application/x-www-form-urlencoded'}
				}).then(function(response){
					console.log(response.data);
					location.reload();
				},function(error){
					console.log(error);
					alert('Đã xảy ra lỗi');
				});
				break;
			case 'edit':
				var url = 'admin/editUser/'+id;
				var data = $.param($scope.user);
				$http({
					method: 'POST',
					url:url,
					data:data,
					headers: {'Content-Type':'application/x-www-form-urlencoded'}
				}).then(function(response){
					console.log(response.data);
					location.reload();
				},function(error){
					console.log(error);
					alert('Đã xảy ra lỗi');
				});
				break;
			default:
				break;
		}
	}
	$scope.confirmDelete = function(id){
		var isConfirmDelete = confirm("Xóa ?");
		if(isConfirmDelete){
			var url = API + 'admin/delUser/' +id;
			$http({
				method: 'GET',
				url:url,
				headers: {'Content-Type':'application/x-www-form-urlencoded'}
			}).then(function(response){
				location.reload();
			},function(error){
				console.log(error);
				alert('Đã xảy ra lỗi');
			});
		}
		else{
			return false;
		}
	}
});