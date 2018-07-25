app.controller('EmployerManagerController', function($http, $scope, $filter, toaster) {
	$scope.empId = "";
	$scope.employer = {};
	var infoEmployer = [];
	var baseUrl = window.location.origin;

	/*-----------Reset function-----------------------*/
	$scope.resetAd = function(id) {
		$scope.load(id);
	}
	var data = [];
	/*---------Load page and get empid from Laravel----------*/
	$scope.load = function() {
		$scope.editable = false;
		$scope.selection = [];

		$http.get('emp/ngadvance').then(function(response) {
			data = angular.copy(response.data);

			$scope.assistant = _.get(data, 'assis', []);
			infoEmployer = _.get(data, 'employer', []);
			$scope.employer = {
				'_id' : infoEmployer._id,
				'name' : infoEmployer.name,
				'website' : infoEmployer.info.website,
				'city' : infoEmployer.city.name,
				'address' : infoEmployer.address['0']['detail'],
				'phone' : infoEmployer.info.phone,
				'description' : infoEmployer.info.description,
				'schedule' : '',
				'cover': infoEmployer.images.cover,
				'avatar': infoEmployer.images.avatar
			};
			$scope.empId = infoEmployer._id;
			$scope.myskills = _.get(data, 'myskills', []);
			$scope.cities = _.get(data, 'cities', []);
			$scope.skills = _.get(data, 'skills', []);
			$scope.posts = _.get(data, 'posts', []);
			//add skill selection
			$scope.myskills.forEach(function(value) {
				$scope.selection.push({ _id:value._id, name:value.name });
			});
		}, function(error) {
			toaster.pop('error', 'Something went wrong', 'Can not get data from service');
		});

		$scope.sortTypePost = '_id';
		$scope.sortReverse = true;
		$scope.sortType = '_id';
		$scope.sortReversePost = true;
	}
	/*---------Load page Basic ---------------------------------*/
	$scope.loadBasic = function() {
		// $scope.empId = employer['_id'];
		$scope.job = null;
		$scope.selection = [];
		$http.get('emp/ngbasic').then(function(response) {
			data = angular.copy(response.data);
			console.info('basic_data', data);
			//chung
			$scope.options = _.cloneDeep(data);
			$scope.emp = _.get(data, 'emp', []);
			$scope.empId = _.get(data.emp, '_id', '');
			$scope.cities = _.get(data, 'cities', []);
			$scope.skills = _.get(data, 'skills', []);
			//rieng
			$scope.follows = _.get(data, 'follows', []);
			angular.forEach($scope.options.posts, function(o) {
				formatLongDate(o, 'date_expired');
			});

			angular.forEach($scope.options.reviews, function(o) {
				formatLongDate(o, 'reviewed_at');
			});
		}, function(error) {
			toaster.pop('error', 'Something went wrong', 'Can not get data from service');
		});
	}

	/**-------Confirm/Deny Assistant------------*/
	$scope.confirm = function(userId) {
		if (confirm('Are you sure ?')) {
			var req = {
	            method: 'POST',
	            url: 'emp/ng-confirm-ass',
	            data: {
	                empId: $scope.employer['_id'],
	                userId: userId
	            },
	            headers: { 'Content-type' : 'application/json' }
	        };
			$http(req).then(function(response) {
				console.log(response);
				if (response.data.status == true) {
					toaster.pop('success', 'Success', response.data.message);
					$scope.assis = response.data.assis;
				} else {
					toaster.pop('error', 'Error', response.data.message);
				}
			}, function(error) {
				toaster.pop('error', 'Something went wrong', 'Can not get data from service');
			});
		}
	}

	$scope.deny = function(id) {
		if (confirm('Are you sure deny this employer?')) {
			$http.get('emp/ngdenyass/' + $scope.empId + "/" + id).then(function(response) {
				if (response.data.status == true) {
					toaster.pop('success', 'Success', response.data.message);
					$scope.assis = response.data.assis;
				} else {
					toaster.pop('error', 'Error', response.data.message);
				}
			}, function(error) {
				toaster.pop('error', 'Something went wrong', 'Can not get data from service');
			});
		}
	}

	/*---------Confirm/Deny Post ----------------*/
	$scope.confirmPost = function(id) {
		if (confirm('Are you sure confirm?')) {
			$http.get('emp/ng-confirm-post/' + id).then(function(response) {
				if (response.data.status == true) {
					toaster.pop('success', 'Success', response.data.message);
					$scope.resetAd($scope.empId);
				} else {
					toaster.pop('error', 'Error', response.data.message);
				}
				console.log(response.data);
			}, function(error) {
				toaster.pop('error', 'Something went wrong', 'Can not get data from service');
			});
		}
	}

	$scope.denyPost = function(id) {
		if (confirm('Are you sure deny this post ?')) {
			$http.get('emp/ng-deny-post/' + id).then(function(response) {
				if (response.data.status == true) {
					$scope.resetAd($scope.empId);
				}
				toaster.pop('success', 'Success', response.data.message);
			}, function(error) {
				toaster.pop('error', 'Something went wrong', 'Can not get data from service');
			});
		}
	}

	/*--------------sort-num of raw in table ASSISTANT-----------------*/
	$scope.showitems = '3';
	$scope.sort = function(type) {
		$scope.sortType = type;
		$scope.sortReverse = !$scope.sortReverse;
	}

	/*filter table with status*/
	$scope.flagStatus = false;
	$scope.filterStatus = 10;
	$scope.filter = function(type) {
		if ($scope.filterStatus != type) {
			$scope.filterStatus = type;
			$scope.flagStatus = true;
		} else {
			$scope.flagStatus = !$scope.flagStatus;
		}
	}

	/*--------------sort-num of raw in table POSTS-----------------*/
	$scope.showitemsPost = '3';
	$scope.sortPost = function(type) {
		$scope.sortTypePost = type;
		$scope.sortReversePost = !$scope.sortReversePost;
	}
	/*filter table with status*/
	$scope.flagStatusPost = false;
	// $scope.filterStatusPost = 1;
	$scope.filterPost = function(type) {
		if ($scope.filterStatusPost != type) {
			$scope.filterStatusPost = type;
			$scope.flagStatusPost = true;
		} else {
			$scope.flagStatusPost = !$scope.flagStatusPost;
		}
	}

	/*--------------------Enable Edit Infomation for Employer------------------*/
	$scope.editInfo = function() {
		$scope.editable = !$scope.editable;
		if (!$scope.editable) {
			$scope.load($scope.empId);
		}
	}

	/*-------------------toggle add/ remove skills-------------------------------*/

	$scope.toggleSelection = function(id, name) {
		// alert('hello');
		var index = $scope.selection.findIndex(i => i._id == id);
		if (index > -1) {
			$scope.selection.splice(index, 1);
		} else {
			$scope.selection.push({_id: id, name: name});
		}

		console.log($scope.selection);
	}

	$scope.checked = function(id) {
		return $scope.selection.findIndex(i => i._id == id) > -1;
	}

	/*------------------------Save edit info--------------------------------------*/
	$scope.updateInfo = function() {
		$scope.employer['skills'] = angular.copy($scope.selection);
		$http({
			method: "post",
			url: "emp/ng-update-info/" + $scope.empId,
			data: $.param({
				employer: $scope.employer
			}),
			headers: { 'Content-type': 'application/x-www-form-urlencoded' }
		}).then(function(response) {
			if (response.data.status == true) {
				$scope.editable = false;
			}
			toaster.pop('success', 'Success', response.data.message);
		}, function(error) {
			toaster.pop('error', 'Something went wrong', 'Can not get data from service');
		});
	}

	/*------------------Annimation of select section-----------------------------*/
	$(document).ready(function() {
		$('.sb-b').click(function(e) {
			//get section to annimate
			e.preventDefault();

			var href = $(this).attr('href');
			var sec = href.slice(href.lastIndexOf('#'));
			// console.log(sec);

			$scope.anniScroll(sec);
			history.pushState(null, null, href); //change url without reload
			console.log('OK');
		});
		//change logo cover and logo
		$('#cover-info').hover(function() {
			console.log('vào');
			$('#cover-above-cover', this).stop(true, true).slideDown("normal");
		}, function() {
			console.log('ra');
			$('#cover-above-cover', this).stop(true, true).hide();
		});
		$('#logo-info').hover(function() {
			console.log('vào');
			$('#cover-above-logo', this).stop(true, true).slideDown("normal");
		}, function() {
			console.log('ra');
			$('#cover-above-logo', this).stop(true, true).hide();
		});

		$('#formChangeCover input[name="file"]').change(function() {
			var file = this.files[0];
		   	var fileType = file["type"];
			var ValidImageTypes = ["image/gif", "image/jpeg","image/jpg", "image/png"];
			if ($.inArray(fileType, ValidImageTypes) < 0) {
		      	alert('Image type invalid ');
			} else {
				$("#formChangeCover").submit();
			}
		});
		$('#formChangeLogo input[name="file"]').change(function() {
			var file = this.files[0];
		   	var fileType = file["type"];
			var ValidImageTypes = [
				"image/gif", "image/jpeg",
				"image/jpg", "image/png"
			];

			if ($.inArray(fileType, ValidImageTypes) < 0) {
		      	alert('Image type invalid ');
			} else {
				$("#formChangeLogo").submit();
			}
		});
	});

	/*------------------------Upload file---------------------------------*/
	$scope.fileCover = function(type) {
		if (type === 1) {
			$('#filecover').click();
		} else {
			if (type === 2) {
				$('#filelogo').click();
			}
		}

	}

	/*-------------------BASIC FUNCTION----------------------------------*/
	$scope.savePost = function(type, id) {
		if (type == 0) {//add
			$http({
				method: "post",
				url: "emp/ng-create-post/" + $scope.emp._id,
				data: $.param({
					job: $scope.job,
					skills: $scope.selection
				}),
				headers: { 'Content-type' : 'application/x-www-form-urlencoded' }
			}).then(function(response) {
				console.log(response.data);
				if (response.data.status == true) {
					$scope.typePost = 1;
					$scope.job = null;
					$scope.selection = [];
					$scope.addPost();
					//update my list posts
					$scope.loadBasic();
				}
				toaster.pop('success', 'Success', response.data.message);
			}, function(error) {
				toaster.pop('error', 'Something went wrong', 'Can not get data from service');
			});
		} else {
			if (type == 1) {//edit
				var datajob = $scope.job;
				var dataskills = $scope.selection;
				$http({
					method: "post",
					url: "emp/ng-edit-post/" + $scope.empId + "/" + id,
					data: $.param({
						job: $scope.job,
						skills: $scope.selection
					}),
					headers: { 'Content-type' : 'application/x-www-form-urlencoded' }
				}).then(function(response) {
					console.log(response);
					if (response.data.status == true) {
						//update my list posts
						$scope.addPost();
						$scope.loadBasic();
					}
					toaster.pop('success', 'Success', response.data.message);
				}, function(error) {
					toaster.pop('error', 'Something went wrong', 'Can not get data from service');
				});
			}
		}
	}

	$scope.addPost = function(type) {
		$scope.showListPosts = false;
		if (type == 0) {//add
			$scope.titleBlock = 'Add New Post';
			$scope.typePost = type;
		} else {
			if (type == 1) {//edit
				$scope.titleBlock = 'Edit Post';
				$scope.typePost = type;
				$scope.idPost = $scope.job._id;
			}
		}
		$scope.addnewpost = !$scope.addnewpost;
		$('#newpost').slideToggle();
		if ($scope.addnewpost) {
			// var pos = $('#newpost').offset().top - 50;
			$scope.anniScroll('#newpost');
		} else {
			$scope.anniScroll('#emp-yourpost');
			$scope.job = null;
			$scope.selection = [];
		}
	}

	$scope.getPost = function(id) {
		$scope.showListPosts = false;
		$http.get('emp/ng-get-post/' + id).then(function(response) {
			console.info(response.data);
			var post = angular.copy(response.data.post);
			$scope.job = {
				_id: post._id,
				name: post.name,
				quantity: post.detail.quantity,
				address: post.detail.address,
				salary: post.detail.salary,
				city: post.city,
				description: post.detail.description,
				benefit: post.detail.benefit,
				requirment: post.detail.requirment,
				date_expired: post.date_expired,
				created_at: post.created_at,
				updated_at: post.updated_at
			}

			var date_expired = moment.utc(_.parseInt(_.get($scope.job, 'date_expired.$date.$numberLong', '')));
			_.set($scope.job, 'date_expired', date_expired._d);
			if (_.size(response.data.postSkills) > 0) {
				response.data.postSkills.forEach(function (value) {
					$scope.selection.push({
						_id: value._id,
						name: value.name
					});
				});
			} else{
				$scope.selection = [];
			}
			$scope.addPost("1");
		}, function(error) {
			toaster.pop('error', 'ERROR', 'Can not get data from service');
		});
	}

	$scope.trashPost = function(idPost) {
		if (confirm('Are you want to delete this post?')) {
			$http.get('emp/ng-trash-post/' + idPost).then(function(response) {
				if (response.data.status == true) {
					$scope.addPost();
					//reload data
					$scope.loadBasic($scope.empId);
				}
				toaster.pop('success', 'Success', response.data.message);
			}, function(error) {
				toaster.pop('error', 'ERROR', 'Can not get data from service');
			});
		}
	}

	$scope.pushPost = function(idPost) {
		if (confirm('Push this post and waiting confirm from Master ?')) {
			if ($scope.typePost == 0) {
				alert('You must save this post');
			} else {
				$http.get('emp/ng-push-post/' + idPost).then(function(response) {
					if (response.data.status == true) {
						//reload data
						$('#newpost').slideToggle();
						$scope.loadBasic($scope.empId);
					}
					toaster.pop('success', 'Success', response.data.message);
				}, function(error) {
					toaster.pop('error', 'ERROR', 'Can not get data from service');
				});
			}
		}
	}

	/*-----------------LIST APPLICATION--------------------------*/
	$scope.showApps = function(listApplications) {
		$scope.curPost = angular.copy(listApplications);
		formatLongDate($scope.curPost, 'date_expired');

		$scope.showListPosts = true;

		//scroll to list
		$scope.anniScroll('#listApplications');
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

	//Funcion annimation scroll
	$scope.anniScroll = function(ele) {
		if (_.isUndefined($(ele).offset())) {
			if (_.includes(window.location.href, 'emp/basic')) {
				window.location.href = baseUrl + '/emp/advance';
			} else {
				window.location.href = baseUrl + '/emp/basic';
			}
		} else {
			var pos = $(ele).offset().top - 50;
			var body = $("html, body");
			body.stop().animate({ scrollTop:pos }, 500, 'swing', function() {
			});
		}
	}

	/*-----------FOR DASHBOARD--------------*/
	$scope.expend = function(type) {
		$scope.expendFlag = true;
		$scope.expendType = type;
	}

	/*---------FOR EMAIL------------------*/
	$scope.getApplication = function(name, email) {
		$scope.infoSendMail = {
			'name' : name,
			'email' : email
		};

		$scope.emailContent = `
		<h3><span style="font-family:Tahoma,Geneva,sans-serif">Chào <em><strong id="email-name">` + $scope.infoSendMail.name + `</strong>!</em></span></h3>

		<p><span style="font-family:Tahoma,Geneva,sans-serif">Chúng tôi đến từ công ty <em><strong><span style="color:#2980b9">` + $scope.employer.name + `<span style="font-size:16px"></span></span> </strong></em> đã xem xét đơn xin việc của bạn và cảm thấy bạn đã đủ điều kiện để chúng tôi kiểm tra Technical cùng với kỹ năng làm việc. Chúng tôi hi vọng bạn sắp xếp thời gian công việc để đến tham dự buổi phỏng vấn của công ty chúng tôi.</span></p>

		<h4><span style="font-family:Tahoma,Geneva,sans-serif">Tên công việc bạn đã apply: <span style="color:#c0392b"><strong>` + $scope.curPost.name + `</strong></span></span></h4>

		<h3><span style="font-size:18px"><span style="font-family:Tahoma,Geneva,sans-serif"><em><strong>Lịch phỏng vấn:</strong></em></span></span></h3>

		<h4 style="margin-left:40px"><span style="font-family:Tahoma,Geneva,sans-serif">Ngày: <strong><em>`+ $filter('date')($scope.emailDate,'dd-MM-yyyy') + `</em></strong></span></h4>

		<h4 style="margin-left:40px"><span style="font-family:Tahoma,Geneva,sans-serif">Giờ: <strong><em>`+ $filter('date')($scope.emailHour,'HH:mm') + `</em></strong></span></h4>

		<h4 style="margin-left:40px"><span style="font-family:Tahoma,Geneva,sans-serif">Địa điểm phỏng vấn: <strong><em>` + $scope.employer.address + `</em></strong></span></h4>

		<p style="text-align:right"><span style="font-family:Tahoma,Geneva,sans-serif">Chào thân ái!<br />
		<strong><em>HR team!</em></strong></span></p>`;
	}

	$scope.updateEmail = function() {
		$scope.getApplication($scope.infoSendMail.name, $scope.infoSendMail.email);
	}

	$scope.detailJob = function(alias, _id) {
		return baseUrl + '/detail-jobs/' + alias + '/' + _id;
	}

	$scope.reStorePost = function(id) {
		console.log('id', id);
		if (confirm('Are you sure ?')) {
			var req = {
	            method: 'POST',
	            url: 'emp/ng-restore-post',
	            data: {
	                jobId: id
	            },
	            headers: { 'Content-type' : 'application/json' }
	        };
			$http(req).then(function(response) {
				console.log(response);
				if (response.data.status == true) {
					toaster.pop('success', 'Success', response.data.message);
					$scope.loadBasic($scope.empId);
				} else {
					toaster.pop('error', 'ERROR', response.data.message);
				}
			}, function(error) {
				toaster.pop('error', 'ERROR', 'Can not get data from service');
			});
		}
	}

	function formatLongDate(data, type) {
		var date = moment.parseZone(
			moment.utc(_.parseInt(_.get(data, type + '.$date.$numberLong', '')))
			).format('YYYY-MM-DD HH:mm');
		if (date == 'Invalid date') {
			date = 'NaN';
		}
        _.set(data, type, date);
	}
});

//use CKEditor by AngularJS
app.directive('ckEditor', function () {
    return {
        require: '?ngModel',
        link: function (scope, elm, attr, ngModel) {
            var ck = CKEDITOR.replace(elm[0]);
            if ( !ngModel) return;
            ck.on('instanceReady', function () {
                ck.setData(ngModel.$viewValue);
            });
            // update ngModel on change
            function updateModel() {
                scope.$apply(function () {
                	ngModel.$setViewValue(ck.getData());
            	});
        	}
	        ck.on('change', updateModel);
	        ck.on('key', updateModel);
	        ck.on('dataReady', updateModel);

	        ngModel.$render = function (value) {
	            ck.setData(ngModel.$viewValue);
	        };
	        //
	        // ngModel.$render();
	    }
	}
});
