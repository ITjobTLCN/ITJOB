'use strict';
var app = angular.module('my-app', ['angularUtils.directives.dirPagination', 'ui.select'],
function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.constant('Constant', {
    MODAL_EDIT : 'edit',
    MODAL_ADD : 'add',
    MODAL_DETAIL : 'detail',
    MODAL_EDIT_ROLE_TITLE: 'Edit role',
    MODAL_ADD_ROLE_TITLE: 'Add role',
    MODAL_EDIT_USER_TITLE: 'Edit user',
    MODAL_ADD_USER_TITLE: 'Add user',
    MODAL_ADD_EMPLOYER_TITLE: 'Add employer',
    MODAL_EDIT_EMPLOYER_TITLE: 'Edit employer',
    MODAL_ADD_SKILL_TITLE: 'Add skill',
    MODAL_EDIT_SKILL_TITLE: 'Edit Skill',
});
