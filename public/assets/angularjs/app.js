'use strict';
var app = angular.module('my-app', ['angularUtils.directives.dirPagination', 'ui.select', 'toaster'],
function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.constant('Constant', {
    MODAL_EDIT : 'edit',
    MODAL_ADD : 'add',
    MODAL_DETAIL : 'detail',
    MODAL_EDIT_ROLE_TITLE: {
        title: 'Edit role',
        class: 'fa fa-pencil'
    },
    MODAL_ADD_ROLE_TITLE: {
        title: 'Add role',
        class: 'fa fa-plus'
    },
    MODAL_EDIT_USER_TITLE: {
        title: 'Edit user',
        class: 'fa fa-pencil'
    },
    MODAL_ADD_USER_TITLE: {
        title: 'Add user',
        class: 'fa fa-plus'
    },
    MODAL_ADD_EMPLOYER_TITLE: 'Add employer',
    MODAL_EDIT_EMPLOYER_TITLE: 'Edit employer',
    MODAL_ADD_SKILL_TITLE: 'Add skill',
    MODAL_EDIT_SKILL_TITLE: 'Edit Skill',
    CHART_APPLICATION: 0,
    CHART_JOB: 1,
    CHART_ACTIVE_USER: 2,

    STATUS: {
        ACTIVATE : 1,
        DEACTIVATE : 2,
    }
});
