app.controller('ApplicationsController', function ($scope, $http, $timeout, Constant) {
    // Set constant
    $scope.constant = Constant;
    // Load default data
    $http.get('admin/ngapplications').then(function (response) {
        $scope.applications = response.data.lists;
    }, function (response) {
        alert(response)
    });

    // Show modal
    $scope.modal = function (state, item) {
        $scope.state = state;
        $scope.application = item;
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

});
