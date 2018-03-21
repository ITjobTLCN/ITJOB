app.controller('SkillsController',function($scope, $http){
	$http({
		method: 'GET',
		url: 'list-skill',	
	}).then(function(response){
		$scope.skills = response.data;
	},function(error){
		console.log(error,'can not get data');
	});

	$scope.listSkillJob=function(job_id){
		$http({
			method: 'GET',
			url: 'list-skill-jobs',
			params:{job_id:job_id}	
		}).then(function(response){
			$scope.skillsjob=response.data[0];
			$scope.relatedJob=response.data[1];
		},function(error){
			console.log(error,'can not get data');
		});
	};
	$scope.listSkillCompanies=function(emp_id){
		var emp_id=emp_id;
		$http({
			method: 'GET',
			url: 'list-skill-emp',
			params:{emp_id:emp_id}	
		}).then(function(response){
			$scope.skillsemp=response.data;
		},function(error){
			console.log(error,'can not get data');
		});
	}
});