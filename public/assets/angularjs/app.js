'use strict';
var app = angular.module('my-app', ['angularUtils.directives.dirPagination', 'ui.select', 'toaster'],
function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.constant('Constant', {
    MODAL_EDIT : 'edit',
    MODAL_ADD : 'add',
    MODAL_EDIT_ROLE_TITLE: 'Edit roles',
    MODAL_ADD_ROLE_TITLE: 'Add roles'
});
