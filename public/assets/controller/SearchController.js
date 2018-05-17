app.filter('propsFilter', function() {
  return function(items, props) {
    var out = [];

    if (angular.isArray(items)) {
      var keys = Object.keys(props);

      items.forEach(function(item) {
        var itemMatches = false;

        for (var i = 0; i < keys.length; i++) {
          var prop = keys[i];
          var text = props[prop].toLowerCase();
          if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
            itemMatches = true;
            break;
          }
        }

        if (itemMatches) {
          out.push(item);
        }
      });
    } else {
      // Let the output be the input untouched
      out = items;
    }

    return out;
  };
})
.controller('SearchController', ['$scope', '$timeout', '$http', function ($scope, $timeout, $http) {
    var vm = this;
    $scope.onSelected = function(item) {
      localStorage.setItem('city', item.name);
    };
    vm.scity = localStorage.getItem('city');
    vm.scity ?
        vm.city = {selected : vm.scity}
        :
        vm.city = {selected : "Hồ Chí Minh"};
    vm.cities = [];
    $http({
        method: 'GET',
        url: 'list-city',
    }).then(function(response) {
        vm.cities = response.data;
    }, function(error) {
        console.log(error,'can not get data');
    });
    $timeout(function() {
        localStorage.removeItem('city');
    }, 1000);
}]);
