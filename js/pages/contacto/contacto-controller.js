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



});