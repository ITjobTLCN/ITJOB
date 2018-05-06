app.controller('JobsController', function($scope,$http) {
	$http({
		method: 'GET',
		url: 'all-attribute-filter',
	}).then(function(response) {
		$scope.myCountry = {
			    selected:{}
			};
		$scope.cities=response.data.locations;
		$scope.skills=response.data.skills;
	},function(error){
		console.log(error, 'can not get data.');
	});
      //filter job by locations and skills
	var i = 0;
	var j = 0;
	var id_city = [];
      var id_skill = [];
      var dem = 0;
	$scope.filterJob = function(event, type, data) {
      // how to check if checkbox is selected or not
            var data = {
                  'id': data._id,
                  'name': data.name,
                  'alias': data.alias,
            }
            if(event.target.checked) {
                  dem++;
                  if(type === "cities") {
                        id_city[i] = data.id;
                        i++;
                  }else {
                        id_skill[j] = data.id;
                        j++;
                  }
                  $('.edition-filter').append('<span id='+ data.alias +'>'+ data.name +'</span>');
                  $('.clear-all-filter-att').css({
                        'display':'block'
                  });
                  $('.list-filter-att').css({
                        'display':'block'
                  });
            } else {
                  dem--;
                  var id = data.id;
                  if(type == "cities") {
                        i--;
                        for(var k = 0; k < id_city.length; k++) {
                              if(id_city[k] === id) {
                                    id_city = $.grep(id_city, function(value) {
                                          return value != id;
                                    });
                              }
                        }
                  }else {
                        j--;
                        for(var k = 0; k < id_skill.length; k++) {
                              if(id_skill[k] === id) {
                                    id_skill = $.grep(id_skill, function(value) {
                                          return value != id;
                                    });
                              }
                        }
                  }
                  $('span#'+data.alias).remove();
            }
            if(dem == 0) {
                  $('.edition-filter').empty();
                  $('.clear-all-filter-att').css({
                        'display':'none'
                  });
                  $('.list-filter-att').css({
                        'display':'none'
                  });
            }
            $.ajaxSetup({
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
            });
            $.ajax({
                  type: 'post',
                  url: 'filter-job',
                  data: {
                        'info_skill': id_skill,
                        'info_city': id_city,
                  },
                  success : function(data) {
                        $('.jb-search__result').html(data[0]);
                        $('.countjob').show().text(data[1]);
                  }
            });
      };
      $scope.clearAll = function(){
            dem = 0;
            angular.forEach($scope.skills, function(skill_id) {
                  skill_id.selected = false;
            });
            angular.forEach($scope.cities, function(city_id) {
                  city_id.selected = false;
            });
            $('.edition-filter').empty();
            $('.list-filter-att').css({
                  'display':'none',
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                  type: 'post',
                  url: 'filter-job',
                  data: {
                        'info_skill':"",
                        'info_city':"",
                  },
                  success : function(data) {
                        $('.jb-search__result').html(data[0]);
                        $('.countjob').show().text(data[1]);
                  }
            });
      }
      $scope.hasFollow = function(job_id) {
            var job_id = job_id;
            $http({
                  type:'get',
                  url:'check-job-followed',
                  params:{ job_id: job_id}
            }).then(function(response) {
                  $scope.jobFollowed = response.data;
            },function(error){
                  console.log(error, 'can not get data');
            });
      };
      $scope.showMoreJob = function() {
            
      }
});

