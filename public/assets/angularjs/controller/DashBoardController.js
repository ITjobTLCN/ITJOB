app.controller('DashBoardController',function($scope,$http,$interval){
	$scope.loadDashboard = function(){
		$scope.clock = "loading...";
		$http.get('admin/ngnumber').then(function(response){
			// console.log(response);
			$scope.countallusers = response.data.countallusers;
			$scope.countusers = response.data.countusers;
			$scope.countadmins = response.data.countadmins;
			$scope.countemployers = response.data.countemployers;
			$scope.countmasters = response.data.countmasters;
			$scope.countassistants = response.data.countassistants;

			//count post approved and expired
			
			$scope.countemps = response.data.countemps;
			$scope.countpendingemps = response.data.countpendingemps;
			$scope.countapprovedemps = response.data.countapprovedemps;
			$scope.countdeniedemps = response.data.countdeniedemps;
			//
			$scope.countusertoday = response.data.countusertoday;
			$scope.countposttoday = response.data.countposttoday;
			$scope.countapplitoday = response.data.countapplitoday;

			$scope.posts =  response.data.posts;
			$scope.countposted =  response.data.countposted;
			
			$scope.countapplies =  response.data.countapplies;
			$scope.newemps =  response.data.newemps;

			//count online user
			$scope.useronline  = response.data.user_online;
		},function(error){
			alert("Can't get data!");
		});
	}
	
	var tick = function() {
	    $scope.clock = Date.now();
  	}
  	$interval(tick, 1000);
});