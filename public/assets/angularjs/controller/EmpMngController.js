app.controller('EmpMngController',function($http,$scope){
	/*---------Load page and get empid from Laravel----------*/
	$scope.load = function(id){
		$scope.empid = id;
		$scope.editable = false;
		console.log($scope.empid);

		$http.get('emp/ngadvance/'+$scope.empid).then(function(response){
			console.log(response.data);
			$scope.assis = response.data.assis;
			$scope.emp = response.data.emp;
			$scope.skills = response.data.skills;
			$scope.mycity = response.data.city;
			$scope.cities = response.data.cities;
		},function(error){
			alert('ERROR');
		});
	}

	/**-------Confirm/Deny Assistant------------*/
	$scope.confirm = function(id){
		if(confirm('Are you sure confirm?')){
			$http.get('emp/ngconfirmass/'+$scope.empid+"/"+id).then(function(response){
				if(response.data.status==true){
					alert(response.data.message);
					$scope.assis = response.data.assis;
				}else{
					alert(response.data.message);
				}
			},function(error){
				alert('ERROR');
			});
		}	
	}
	$scope.deny = function(id){
		if(confirm('Are you sure deny this employer?')){
			$http.get('emp/ngdenyass/'+$scope.empid+"/"+id).then(function(response){
				if(response.data.status==true){
					alert(response.data.message);
					$scope.assis = response.data.assis;
				}else{
					alert(response.data.message);
				}
			},function(error){
				alert('ERROR');
			});
		}	
	}
	/*--------End Confirm/Deny Assistant--------------*/


	/*sort-num of raw in table*/
	$scope.showitems = '3';
	$scope.sort = function(type){
		$scope.sortType = type;
		$scope.sortReverse = !$scope.sortReverse;
	}
	/*filter table with status*/
	$scope.flagStatus = false;
	$scope.filterStatus = 10;
	$scope.filter = function(type){
		if($scope.filterStatus != type){
			$scope.filterStatus = type;
			$scope.flagStatus = true;
		}else{
			$scope.flagStatus = !$scope.flagStatus;
		}
	}

	/*--------------------Enable Edit Infomation for Employer------------------*/
	$scope.editInfo = function(){
		$scope.editable = !$scope.editable;
		if(!$scope.editable){
			$scope.load($scope.empid);
		}
	}
	/*-----------------End Enable Edit Infomation for Employer------------------*/

	/*------------------Annimation of select section-----------------------------*/
	$(document).ready(function(){
		$('.sb-b').click(function(e){
			//get section to annimate
			e.preventDefault();

			var href = $(this).attr('href');
			var sec = href.slice(href.lastIndexOf('#'));
			// console.log(sec);

			var pos = $(sec).offset().top - 50;
			var body = $("html, body");
			body.stop().animate({scrollTop:pos}, 500, 'swing', function() { 
			});
			history.pushState(null, null, href); //change url without reload
			
			console.log('OK');
		});
	});
});