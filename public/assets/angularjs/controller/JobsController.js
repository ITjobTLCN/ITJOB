app.controller('JobsController', function ($scope, $http, $timeout, Constant) {
    // Set constant
    $scope.constant = Constant;
    // Load default data
    $http.get('admin/ngjobs').then(function (response) {
        $scope.jobs = response.data.lists;
    }, function (response) {
        alert(response)
    });
    $http.get('admin/ngskills').then(function(response){
         $scope.skills = response.data.skills;
    }, function(response){alert(response)});

    // Show modal
    $scope.modal = function (state, item) {
        $scope.state = state;
        $scope.job = item;
        switch (state) {
            case Constant.MODAL_DETAIL:
                // $scope.modal_title = $scope.job.name;
                break;
            default:
                break;
        }
        $('#modal_detail').modal('show');
    }

    /**
     * Paging, search and sort
     */
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
        $scope.sort_type = 'created_at';
        $scope.sort_reverse = true;
    }

    /**
     * Check, common function
     */
    $scope.inArraySkill = function(skill_id, skills_id) {
        return skills_id.indexOf(skill_id) !== -1;
    }
});
