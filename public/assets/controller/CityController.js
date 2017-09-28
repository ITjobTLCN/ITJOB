app.controller('CityController',function($scope,$http) {
	$http({
      method: 'GET',
      url: 'listcity'
   }).then(function (response){
   		$scope.cities=response.data;
   },function (error){
		console.log(error, 'can not get data.');
   });
})