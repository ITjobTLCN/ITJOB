'use strict';
var app = angular.module('my-app', ['angularUtils.directives.dirPagination', 'ui.select'], 
function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});