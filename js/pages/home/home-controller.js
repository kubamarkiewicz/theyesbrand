app.controller('HomeController', function($scope, $rootScope, $http, $routeParams, config) {  

	$('section#home-banners .container').appear(function() {
     	$(this).addClass('appeared');
    });

});