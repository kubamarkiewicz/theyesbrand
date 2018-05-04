app.controller('ContactoController', function($scope, $rootScope, $http, $routeParams, config, $translate) {  
   

    // CONTACT FORM
    $scope.contactSent = false;

    $scope.submit = function () 
    {
        $http({
            method  : 'POST',
            url     : config.api.urls.sendContact,
            data    : {
                "name" : $scope.name,
                "email" : $scope.email,
                "subject" : $scope.subject,
                "message" : $scope.message
            }
        })
        .then(function(response) {
            if (response.data && response.data != 'false') {
            	$scope.contactSent = true;
            }
            $("#my-form button[type=submit]").button('reset').attr('disabled', false);
        });
         
        // block button 
        $("#my-form button[type=submit]").button('loading').attr('disabled', true);

    }




    $scope.translations = [];

    $translate(['pages.contacto.mapa latitude', 'pages.contacto.mapa longitude']).then(function (translations) {
        $scope.translations = translations;


        // Google Maps

        // var coordinates = new google.maps.LatLng(41.289427,1.5617157);
        var coordinates = new google.maps.LatLng($scope.translations['pages.contacto.mapa latitude'],$scope.translations['pages.contacto.mapa longitude']);

        var myOptions = {
            zoom: 13,
            center: coordinates,
            // mapTypeId: 'terrain',
            styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
        };
        var map = new google.maps.Map(document.getElementById("contacto-map"), myOptions); 

        var marker = new google.maps.Marker({
            position: coordinates,
            map: map
        });

        var infowindow = new google.maps.InfoWindow({
            content: 'The Yes Brand'
        });

        google.maps.event.addListener(marker, 'click', function() {
           infowindow.open(map, marker);
        });

        infowindow.open(map, marker);


    });

 


});