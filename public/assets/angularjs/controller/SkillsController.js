app.controller('SkillsController', function ($scope, $http, $timeout, Constant) {
     // Set constant
     $scope.constant = Constant;
     // Load default data
     $http.get('admin/ngskills').then(function (response) {
         $scope.skills = response.data.skills;
     }, function (response) {
         alert(response)
     });

    // Show modal
    $scope.modal = function (state, item) {
        $scope.state = state;
        $scope.skill = item;
        switch (state) {
            case Constant.MODAL_ADD:
                $scope.modal_title = Constant.MODAL_ADD_SKILL_TITLE;
                break;
            case Constant.MODAL_EDIT:
                $scope.modal_title = Constant.MODAL_EDIT_SKILL_TITLE;
                break;
            default:
                break;
        }
        $('#modal_detail').modal('show');
    }

    // Save data
    $scope.save = function () {
        $scope.errors = undefined;
        var data = {};
        if ($scope.skill != undefined) {
            ($scope.created_at) ? delete $scope.created_at: null;
            ($scope.updated_at) ? delete $scope.updated_at: null;
            data = $.param($scope.skill);
        }
        //delele some scope variables

        console.log(data);
        switch ($scope.state) {
            case Constant.MODAL_ADD:
                $scope.create_skill(data);
                break;
            case Constant.MODAL_EDIT:
                $scope.edit_skill(data);
                break;
            default:
                break;
        }
    }

    $scope.delete = function (id) {
        $scope.errors_delete = undefined;
        data = $.param({
            '_id': id
        });
        $scope.delete_skill(data);
    }


    /**
     * COMMON FUNCTION
     */
    $scope.create_skill = function (data) {
        $http({
            method: "POST",
            url: "admin/ngskill",
            data: data,
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            }
        }).then(function (response) {
            if (response.data.status == true) {
                alert(response.data.message);
                //push skill to scope user
                $scope.skills.splice(0, 0, response.data.skill);
                $('#modal_detail').modal('hide');
            } else {
                $scope.errors = response.data.errors;
                $timeout(function () {
                    $scope.errors = undefined;
                }, 5000);
            }
        }, function (error) {
            alert(error);
        });
    }

    $scope.edit_skill = function (data) {
        $http({
            method: "PUT",
            url: "admin/ngskill",
            data: data,
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            }
        }).then(function (response) {
            if (response.data.status == true) {
                alert(response.data.message);
                //load list skills
                $scope.skills = response.data.skills;
                $('#modal_detail').modal('hide');
            } else {
                $scope.errors = response.data.errors;
                $timeout(function () {
                    $scope.errors = undefined;
                }, 5000);
            }
        }, function (error) {
            alert(error);
        });
    }

    $scope.delete_skill = function (data) {
        if (!confirm("Delete this skills?")) {
            return;
        }
        $http({
            method: "DELETE",
            url: "admin/ngskill",
            data: data,
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            }
        }).then(function (response) {
            if (response.data.status == true) {
                alert(response.data.message);
                //load list skills
                $scope.skills = response.data.skills;
                $('#modal_detail').modal('hide');
            } else {
                $scope.errors_delete = response.data.errors;
                $timeout(function () {
                    $scope.errors_delete = undefined;
                }, 5000);
            }
        }, function (error) {
            alert(error);
        });
    }


    /*sort-filer-search TABLE with angular */
    $scope.show_items = '5';
    $scope.sort = function (keyname) {
        // Old result
        if (keyname === $scope.sort_type) {
            // Check if sort ASCENDING
            if ($scope.sort_reverse == false) {
                $scope.frezingOrder();
            } else {
                $scope.sort_reverse = false;
            }
        } else {
            $scope.sort_type = keyname;
            $scope.sort_reverse = true;
        }
    }

    // Freezing default to feild: created_at, desc
    $scope.frezingOrder = function () {
        $scope.sort_type = '_id';
        $scope.sort_reverse = true;
    }
});
