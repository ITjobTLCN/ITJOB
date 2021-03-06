app.controller('JobsController', function($scope,$http) {
	$http({
		method: 'GET',
		url: 'all-attribute-filter',
	}).then(function(response) {
		$scope.myCountry = {
			    selected:{}
			};
            $scope.salary = {
                  'thấp' : {
                        _id : '1',
                        name : 'thấp',
                        alias : 'thấp',
                        label : '0 - 500',
                        value : '0-500'
                  },
                  'vừa' : {
                        _id : '2',
                        name : 'vừa',
                        alias : 'vừa',
                        label : '500 - 1000',
                        value : '500-1000',
                  },
                  'cao' : {
                        _id : '3',
                        name : 'cao',
                        alias : 'cao',
                        label : '1000 - 2000',
                        value : '1000-2000'
                  }
            };
		$scope.cities = response.data.locations;
		$scope.skills = response.data.skills;
	},function(error) {
		console.log(error, 'can not get data.');
	});
      //filter job by locations and skills
	var i = 0;
	var salary = [];
      var id_skill = [];
      var dem = 0;
      $scope.checkDisableFilter = false;
	$scope.filterJob = function(event, type, data) {
            var arrData = {
                  'id': data._id,
                  'name': data.name,
                  'alias': data.alias,
            }

            if (event.target.type === 'radio') {
                  salary[0] = data.value;
            }
            if(event.target.type === 'checkbox') {
                  if(event.target.checked) {
                        // dem++;
                        id_skill[i] = arrData.id;
                        i++;
                  } else {
                        // dem--;
                        var id = arrData.id;
                        i--;
                        for(var k = 0; k < id_skill.length; k++) {
                              if(id_skill[k] === id) {
                                    id_skill = $.grep(id_skill, function(value) {
                                          return value != id;
                                    });
                              }
                        }
                  }
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
                        'info_salary': salary,
                  },
                  success : function(data) {
                        console.log(data);
                        if(data[2] == true) {
                              $('#no-results-message').css({
                                    'display' : 'none'
                              });
                              $('#countjob').css({
                                    'display' : 'block'
                              });
                        }
                        $('.jb-search__result').html(data[0]);
                        $('.countjob').show().text(data[1]);
                  }
            });
      };

      $scope.clearAll = function() {
            if ($scope.checkDisableFilter) {
                  window.location = "http://itjob.local.vn/it-job/all-jobs";
            } else {
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });

                  $.ajax({
                        type: 'post',
                        url: 'filter-job',
                        data: {
                              'info_skill': [],
                              'info_salary': [],
                        },
                        success : function(data) {
                              console.log(data);
                              reset();
                              $('.jb-search__result').html(data[0]);
                              $('.countjob').show().text(data[1]);
                        }
                  });
            }
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

      function reset() {
            //reset value
            id_skill = [];
            salary = [];
            i = 0;

            $('input:checkbox').removeAttr('checked');
            $('input:radio').removeAttr('checked');
      }

      $scope.disableFilter = function(quantityJob) {
            return $scope.checkDisableFilter = (quantityJob == 0);
      }
});

