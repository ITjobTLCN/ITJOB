app.controller('RolesController', function ($scope, $http, $timeout, Constant, toaster) {
    // Load default data
    $http({
        method: 'GET',
        url: 'admin/ngroles'
    }).then(function (response) {
        $scope.roles = response.data.roles;
        $scope.constant = Constant;
    }, function (error) {
        toaster.pop('error', 'ERROR', error);
    });

    // Show modal
    $scope.modal = function(state, item) {
        $scope.state = state;
        $scope.role = item;
        switch (state) {
            case Constant.MODAL_ADD:
                $scope.role_modal = Constant.MODAL_ADD_ROLE_TITLE;
                break;
            case Constant.MODAL_EDIT:
                $scope.role_modal = Constant.MODAL_EDIT_ROLE_TITLE;
                break;
            default:
                break;
        }
        $('#role_modal').modal('show');
    }

    // Save data
    $scope.save = function() {
        debugger;
        $scope.errors = undefined;
        var data = {};
        if (!_.isUndefined($scope.role)) {
            ($scope.created_at) ? delete $scope.created_at: null;
            ($scope.updated_at) ? delete $scope.updated_at: null;
            data = $.param($scope.role);
        }
        //delele some scope variables

        console.log(data);
        switch ($scope.state) {
            case Constant.MODAL_ADD:
                $scope.create_role(data);
                break;
            case Constant.MODAL_EDIT:
                $scope.edit_role(data);
                break;
            default:
                break;
        }
    }

    $scope.delete = function(id) {
        $scope.errors_delete = undefined;
        data = $.param({'_id': id});
        $scope.delete_role(data);
    }


    /**
     * COMMON FUNCTION
     */
    $scope.create_role = function(data){
        $http({
            method: "POST",
            url: "admin/ngrole",
            data: data,
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            }
        }).then(function (response) {
            if (response.data.status == true) {
                toaster.pop('success', 'Success', response.data.message);
                //push role to scope user
                $scope.roles.splice(0, 0, response.data.role);
                $('#role_modal').modal('hide');
            } else {
                $scope.errors = response.data.errors;
                $timeout(function () {
                    $scope.errors = undefined;
                }, 5000);
            }
        }, function (error) {
            toaster.pop('error', 'ERROR', error);
        });
    }

    $scope.edit_role = function(data) {
        $http({
            method: "PUT",
            url: "admin/ngrole",
            data: data,
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            }
        }).then(function (response) {
            if (response.data.status == true) {
                toaster.pop('success', 'Success', response.data.message);
                //load list roles
                $scope.roles = response.data.roles;
                $('#role_modal').modal('hide');
            } else {
                $scope.errors = response.data.errors;
                $timeout(function () {
                    $scope.errors = undefined;
                }, 5000);
            }
        }, function (error) {
            toaster.pop('error', 'ERROR', error);
        });
    }

    $scope.delete_role = function (data) {
        if (!confirm("Are you sure to want to delete?")) {
            return;
        }
        $http({
            method: "DELETE",
            url: "admin/ngrole",
            data: data,
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            }
        }).then(function (response) {
            if (response.data.status == true) {
                toaster.pop('success', 'Success', response.data.message);
                //load list roles
                $scope.roles = response.data.roles;
                $('#role_modal').modal('hide');
            } else {
                $scope.errors_delete = response.data.errors;
                $timeout(function () {
                    $scope.errors_delete = undefined;
                }, 5000);
            }
        }, function (error) {
            toaster.pop('error', 'ERROR', error);
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
        $scope.sort_type = 'created_at';
        $scope.sort_reverse = true;
    }
});
