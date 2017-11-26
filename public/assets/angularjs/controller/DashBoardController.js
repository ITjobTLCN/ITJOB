app.controller('DashBoardController',function($scope,$http){
	$http.get('admin/ngnumber').then(function(response){
		console.log(response);
		$scope.countallusers = response.data.countallusers;
		$scope.countusers = response.data.countusers;
		$scope.countadmins = response.data.countadmins;
		$scope.countemployers = response.data.countemployers;
		$scope.countmasters = response.data.countmasters;
		$scope.countassistants = response.data.countassistants;
	},function(error){
		alert("Can't get data!");
	});
});