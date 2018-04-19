app.controller('ProyectoController', function($scope, $rootScope, $http, $routeParams, config) {  
   
    $scope.proyectoData = null;
    
    $http({
        method  : 'GET',
        url     : config.api.urls.getProyecto.replace(':slug', $routeParams.slug)
    })
    .then(function(response) {
        $scope.proyectoData = response.data;
    });

});