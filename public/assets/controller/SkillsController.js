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

	$scope.listSkillJob=function($job_id){
		var job_id=$job_id;
		$http({
			method: 'GET',
			url: 'list-skill-jobs',
			params:{job_id:job_id}	
		}).then(function(response){
			$scope.skillsjob=response.data;
		},function(error){
			console.log(error,'can not get data');
		});
	};
	$scope.ralatedJob=function($job_id){
		
	};
});