app.controller('JobsController', function($scope,$http){
	$http({
		method: 'GET',
		url: 'all-attribute-filter',
	}).then(function(response){
		$scope.myCountry = {
			    selected:{}
			};
            $scope.hoten="Tran Thanh Phong";
		$scope.cities=response.data.locations;
		$scope.skills=response.data.skills;
	},function(error){
		console.log(error, 'can not get data.');
	});
      //filter job by locations and skills
	var i=0;
	var j=0;
	var id_city=[];
      var id_skill=[];
      var dem=0;
	$scope.toggleSelection = function toggleSelection(event,t,id,name,alias) {
      // how to check if checkbox is selected or not
            var name = name;
            if(event.target.checked){
            	if(t=="cities"){
            		id_city[i]=id;
            		i++;
            	}else{
            		id_skill[j]=id;
            		j++;
            	}
            	$('.edition-filter').append('<p id='+alias+'>'+name+'<br></p>');
            	dem++;
                  $('.clear-all-filter-att').css({
                        'display':'block'
                  });
                  $('.list-filter-att').css({
                        'display':'block'
                  });
            }else{
            	if(t=="cities"){
                        $scope.checkedl=false;
            		for(var k=0;k<id_city.length;k++){
            			if(id_city[k]==id){
            				var removeItem = id;
            				id_city=$.grep(id_city,function(value){
            					return value != removeItem;
            				});
            			}
            		}
            	}else{
                        $scope.checkeds=false;
            		for(var l=0;l<id_skill.length;l++){
            			if(id_skill[l]==id){
            				var removeItem = id;
            				id_skill=$.grep(id_skill,function(value){
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
            info_skill=[];
            info_city=[];
		$.ajax({
			type:'get',
			url:'filter-job',
			data:{
				'info_skill':id_skill,'info_city':id_city,
			},
			success : function(data){
				$('.jb-search__result').html(data);
			}
		});
      };
      $scope.clearall=function(){
            id_city=[];
            id_skill=[];
            dem=0;
            $scope.checkedl=!$scope.checkedl;
            $scope.checkeds=!$scope.checkeds;
            $('.list-filter-att').hide();
            $('.edition-filter').empty();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                  type:'get',
                  url:'filter-job',
                  data:{
                        'info_skill':id_skill,'info_city':id_city,
                  },
                  success : function(data){
                        console.log(data);
                        $('.jb-search__result').html(data);
                  }
            });
      }
      $scope.hasFollow=function(job_id){
            var job_id=job_id;
            $http({
                  type:'get',
                  url:'check-job-followed',
                  params:{job_id:job_id}
            }).then(function(response){
                  alert(response.data);
                  $scope.jobFollowed=response.data;
            },function(error){
                  console.log(error,'can not get data');
            });
      };
});
app.directive('bsPopover', function() {
    return function(scope, element, attrs) {
        element.find("i[rel=popover]").popover({ 
            trigger: "manual" , 
            html: true, 
            placement: "bottom",
            content: '<span class=".pop-content"> You must <a href="#" data-toggle="modal" data-target="#loginModal">Login </a>to do this</span>',
            animation:false})
        .on("mouseenter", function () {
            var _this = this;
            $(this).popover("show");
            $(".popover").on("mouseleave", function () {
                  $(_this).popover('hide');
            });
      }).on("mouseleave", function () {
            var _this = this;
            setTimeout(function () {
                  if (!$(".popover:hover").length) {
                        $(_this).popover("hide");
                  }
            }, 100);
      });
    };
});

