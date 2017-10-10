app.controller('CityController',function($scope,$http) {
	$http({
      method: 'GET',
      url: 'list-city'
   }).then(function (response){
   		$scope.cities=response.data;
   },function (error){
		console.log(error, 'can not get data.');
   });
});