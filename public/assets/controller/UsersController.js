app.controller('UsersController',function($scope,$http){
	$http({
      method: 'GET',
      url: 'list'
   }).then(function (response){
   		
   },function (error){
		console.log(error, 'can not get data.');
   });
});