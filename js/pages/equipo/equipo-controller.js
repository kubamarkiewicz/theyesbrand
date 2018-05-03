app.controller('EquipoController', function($scope, $rootScope, $http, $routeParams, config, $translate) {  
   
	// $scope.translations = [];

/*    $translate(['pages.equipo.imagen del fondo', 'pages.equipo.texto']).then(function (translations) {
        $scope.translations = translations;
        console.log($scope.translations);
    });*/

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

});