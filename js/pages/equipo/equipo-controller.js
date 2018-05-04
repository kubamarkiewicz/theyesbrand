app.controller('EquipoController', function($scope, $rootScope, $http, $routeParams, config, $translate) {  
   
   $scope.onGalleryRendered = function () {

		$(document).ready(function(){

			$('#equipo-slides').slick({
				arrows: false,
				infinite: true,
				speed: 700,
				autoplay: true,
				slidesToShow: 3,
				slidesToScroll: 1,
				centerMode: true,
				focusOnSelect: true,
				responsive: [
					{
					  breakpoint: 480,
					  settings: {
					    slidesToShow: 1
					  }
					}
				]
			});
			
		});

	}

    

});