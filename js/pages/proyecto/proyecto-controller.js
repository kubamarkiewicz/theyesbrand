app.controller('ProyectoController', function($scope, $rootScope, $http, $routeParams, config) {  
   
    $scope.slug = $routeParams.slug;

    if ($rootScope.proyectosData) {
	    document.title = $rootScope.proyectosData[$scope.slug].name + ' - ' + document.title;
    }

});