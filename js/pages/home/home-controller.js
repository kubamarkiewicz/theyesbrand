app.controller('HomeController', function($scope, $rootScope, $http, $routeParams, config) {  

	$scope.onBannersRendered = function () 
	{
		console.log('finished');
		$('section#home-banners .container').appear(function() {
	     	$(this).addClass('appeared');
	    });
	}

});