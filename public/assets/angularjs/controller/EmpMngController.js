app.controller('EmpMngController',function($http,$scope){
	/*---------Load page and get empid from Laravel----------*/
	$scope.load = function(id){
		$scope.empid = id;
		$scope.editable = false;
		$scope.selection = [];
		console.log($scope.empid);

		$http.get('emp/ngadvance/'+$scope.empid).then(function(response){
			console.log(response.data);
			$scope.assis = response.data.assis;
			$scope.emp = response.data.emp;
			$scope.myskills = response.data.myskills;
			$scope.mycity = response.data.city;
			$scope.cities = response.data.cities;
			$scope.skills = response.data.skills;

			//add skill selection 
			$scope.myskills.forEach(function(value){
				$scope.selection.push({id:value.id,name:value.name});
			});
			console.log($scope.selection);
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

	/*-------------------toggle add/ remove skills-------------------------------*/

	$scope.toggleSelection = function(id,name){
		// alert('hello');
		var index = $scope.selection.findIndex(i=>i.id == id);
		if(index>-1){
			$scope.selection.splice(index,1);
		}else{
			$scope.selection.push({id:id,name:name});
		}
		console.log($scope.selection);
	}
	$scope.checked = function(id){
		return $scope.selection.findIndex(i=>i.id == id)>-1;
	}

	/*------------------------Save edit info--------------------------------------*/
	$scope.updateInfo = function(){
		$http({
			method:"post",
			url: "emp/ngupdateinfo/"+$scope.empid,
			data:$.param({emp:$scope.emp,skills:$scope.selection}),
			headers: {'Content-type':'application/x-www-form-urlencoded'}
		}).then(function(response){
			if(response.data.status==true){
				$scope.editable = false;
			}
			alert(response.data.message);
		},function(error){
			alert('ERROR');
		});
		console.log('Hi');
	}

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
		//change logo cover and logo
		$('#cover-info').hover(function(){
			console.log('vào');
			  $('#cover-above-cover', this).stop(true, true).slideDown("normal");
		},function(){
			console.log('ra');
			  $('#cover-above-cover', this).stop(true, true).hide();
		});
		$('#logo-info').hover(function(){
			console.log('vào');
			  $('#cover-above-logo', this).stop(true, true).slideDown("normal");
		},function(){
			console.log('ra');
			  $('#cover-above-logo', this).stop(true, true).hide();
		});

		$('#formChangeCover input[name="file"]').change(function(){
			var file = this.files[0];
		   	var fileType = file["type"];
			var ValidImageTypes = ["image/gif", "image/jpeg","image/jpg", "image/png"];
			if ($.inArray(fileType, ValidImageTypes) < 0) {
		      	alert('Image type invalid ');
			}else{
				$("#formChangeCover").submit();
			}
		});
		$('#formChangeLogo input[name="file"]').change(function(){
			var file = this.files[0];
		   	var fileType = file["type"];
			var ValidImageTypes = ["image/gif", "image/jpeg","image/jpg", "image/png"];
			if ($.inArray(fileType, ValidImageTypes) < 0) {
		      	alert('Image type invalid ');
			}else{
				$("#formChangeLogo").submit();
			}
		});
	});

	/*------------------------Upload file---------------------------------*/
	$scope.fileCover = function(type){
		if(type==1){
			$('#filecover').click();
		}else{
			if(type==2){
				$('#filelogo').click();
			}
		}

	}

	/**----------------TEST ZONE--------------------*/
	$scope.selectDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
	$scope.selectedList = {};

	/**
	 * Action
	 */
	$scope.submit = function () {
	    angular.forEach($scope.selectedList, function (selected, day) {
	        if (selected) {
	           console.log(day);
	        }
	    });
	};
	/**-------------END TEST ZONE--------------------*/
});