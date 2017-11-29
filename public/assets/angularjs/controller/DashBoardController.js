app.controller('DashBoardController',function($scope,$http){
	$http.get('admin/ngnumber').then(function(response){
		console.log(response);
		$scope.countallusers = response.data.countallusers;
		$scope.countusers = response.data.countusers;
		$scope.countadmins = response.data.countadmins;
		$scope.countemployers = response.data.countemployers;
		$scope.countmasters = response.data.countmasters;
		$scope.countassistants = response.data.countassistants;

		$scope.countemps = response.data.countemps;
		$scope.countpendingemps = response.data.countpendingemps;
		$scope.countapprovedemps = response.data.countapprovedemps;
		$scope.countdeniedemps = response.data.countdeniedemps;
	},function(error){
		alert("Can't get data!");
	});
});