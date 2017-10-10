app.controller('SkillsController',function($scope,$http){
	$http({
		method: 'GET',
		url: 'list-skill',	
	}).then(function(response){
		// $scope.hoten="Tran Thanh Phong";
		$scope.skills=response.data;
	},function(error){
		console.log(error,'can not get data');
	});
});