var app=angular.module('my-app',['angularUtils.directives.dirPagination'],function($interpolateProvider){
	$interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

