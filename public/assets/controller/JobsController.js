app.controller('JobsController', function($scope,$http){
	$http({
		method: 'GET',
		url: 'all-attribute-filter',
	}).then(function(response){
		$scope.myCountry = {
			    selected:{}
			};
		$scope.cities=response.data.locations;
		$scope.skills=response.data.skills;
	},function(error){
		console.log(error, 'can not get data.');
	});
      //load list job default when load page
      $http({
            type:'get',
            url:'list-job-lastest'
      }).then(function(response){
            //console.log(response.data);
            $scope.jobs=response.data;
      },function(error){
            console.log(error, 'can not get data.');
      });
      //skills
      $scope.init=function(job_id){
            var job_id=job_id;
            $http({
                  type:'get',
                  url:'skill-by-job-id',
                  params:{'job_id':job_id}
            }).then(function(response){
                  console.log(response.data);
                  $scope.skillofJob=response.data;
            },function(error){
                  console.log(error, 'can not get data.');
            });
      };

      //filter job by locations and skills
	var i=0;
	var j=0;
	id_city=[];
      id_skills=[];
      var dem=0;
	$scope.toggleSelection = function toggleSelection(event,t,id,name,alias) {
      // how to check if checkbox is selected or not
            var name = name;
            if(event.target.checked){
            	if(t=="cities"){
            		id_city[i]=id;
            		i++;
            	}else{
            		id_skills[j]=id;
            		j++;
            	}
            	$('.edition-filter').append('<p id='+alias+'>'+name+' <i class="fa fa-trash-o" aria-hidden="true"></i><br></p>');
            	dem++;
            }else{
            	if(t=="cities"){
            		for(var k=0;k<id_city.length;k++){
            			if(id_city[k]==id){
            				var removeItem = id;
            				id_city=$.grep(id_city,function(value){
            					return value != removeItem;
            				});
            			}
            		}
            	}else{
            		for(var k=0;k<id_skills.length;k++){
            			if(id_skills[k]==id){
            				var removeItem = id;
            				id_skills=$.grep(id_skills,function(value){
            					return value != removeItem;
            				});
            			}
            		}
            	}
            	$('#'+alias).find("br").remove();
            	$('p#'+alias).remove();
            	dem--;
            }
            if(dem==0){
            	$('.edition-filter').empty();
            }
            $.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		info_city=[];
		info_skill=[];
		$.ajax({
			type:'get',
			url:'filter-job',
			data:{
				info_city:id_city,
				info_skill:id_skills
			},
			success : function(data){
				//console.log(data);
				$('.jb-search__result').html(data);
			}
		});
      		//console.log(t);
      };
});