
var app = angular.module("myApp", [
    "ngRoute",
    "ngSanitize",
    'pascalprecht.translate'
]);

// load configuration from files
app.constant('config', window.config);




// translations

app.config(['$translateProvider', function ($translateProvider) {

    // choose language form local storage or default
    if (!window.localStorage.locale) {
        window.localStorage.locale = config.defaultLanguage;
    }
    $translateProvider.preferredLanguage(window.localStorage.locale);

    $translateProvider.useUrlLoader(config.api.urls.getTranslations);
    $translateProvider.useSanitizeValueStrategy(null);
    // tell angular-translate to use your custom handler
    $translateProvider.useMissingTranslationHandler('missingTranslationHandlerFactory');


}]);

// define missing Translation Handler
app.factory('missingTranslationHandlerFactory', function () {

    var missingTranslations = {
        codes : [],
        translations : [],
        types : [],
        parameters : []
    };

    return function (translationId) {

        // prevent multiple calls
        var index = missingTranslations.codes.indexOf(translationId);
        if (index != -1) {
            return missingTranslations.translations[index];
        }

        // call API: send all missing translations at once
        if (!missingTranslations.codes.length) {
            setTimeout(function(){ 
                $.post({
                    url     : config.api.urls.missingTranslations,
                    data    : {
                        codes : missingTranslations.codes,
                        types : missingTranslations.types,
                        translations : missingTranslations.translations,
                        parameters : missingTranslations.parameters
                    }
                });
            }, 1000);
        }

        // use last element from translationId as default translation
        var translation = translationId.substr(translationId.lastIndexOf(".") + 1);
        var type;
        var parameters = {};

        // find html element
        var element = $("[translate='" + translationId + "'], [translate-cloak='" + translationId + "'], [translate-attr-src='" + translationId + "']");
        if (element) {
            if (element.html()) {
                translation = element.html();
            }
            type = element.attr('translate-type');
            switch (type) {
                case 'image-mediafinder':
                    parameters.width = element.attr('translate-width');
                    parameters.height = element.attr('translate-height');
                    parameters.mode = element.attr('translate-mode');
                    translation = element.attr('src');
                    break;
            }
        }

        // add missing translation to the table         
        missingTranslations.codes.push(translationId);
        missingTranslations.translations.push(translation);
        missingTranslations.types.push(type);
        missingTranslations.parameters.push(parameters);
        
        return translation;
    };

});



// ROUTING ===============================================
app.config(function ($routeProvider, $locationProvider) { 
    
    $routeProvider 

        .when('/', { 
            controller: 'HomeController', 
            templateUrl: 'js/pages/home/index.html' 
        }) 
        .when('/proyectos/:slug', { 
            controller: 'ProyectoController', 
            templateUrl: 'js/pages/proyecto/index.html' 
        }) 
        .when('/proyectos', { 
            controller: 'ProyectosController', 
            templateUrl: 'js/pages/proyectos/index.html' 
        })   
        .otherwise({ 
            redirectTo: '/' 
        }); 

    // remove hashbang
    $locationProvider.html5Mode(true);
});

// CORS fix
app.config(['$httpProvider', function($httpProvider) {
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
    }
]);


app.run(function($rootScope, $sce, $http, $location, $translate, $window, $route) {

    $rootScope.homeSlug = 'home';

    $("body").removeClass('loading');

    $rootScope.$on('$routeChangeStart', function (event, next, prev) 
    {
        // set body class as "prev-page-slug"
        $("body")
        .removeClass(function (index, className) {
            return (className.match (/(^|\s)prev-page-\S+/g) || []).join(' ');
        })
        .addClass("prev-page-"+$rootScope.pageSlug);

        // find page slug
        delete $rootScope.pageSlug;
        if (typeof next.originalPath !== undefined && next.originalPath && next.originalPath.length > 1) {
            $rootScope.pageSlug = next.originalPath.substring(1);
            // substring until first slash
            if ($rootScope.pageSlug.indexOf('/') != -1) {
                $rootScope.pageSlug = $rootScope.pageSlug.substr(0, $rootScope.pageSlug.indexOf('/'));
            }
        }
        if ($rootScope.pageSlug == undefined) {
            $rootScope.pageSlug = $rootScope.homeSlug;
        }

        // set body class as "page-slug"
        $("body")
        .removeClass(function (index, className) {
            return (className.match (/(^|\s)page-\S+/g) || []).join(' ');
        })
        .addClass("page-"+$rootScope.pageSlug);

        $rootScope.setMetadata(); 
    });

    $rootScope.$on('$routeChangeSuccess', function() {

    });


    // fix for displaying html from model field
    $rootScope.trustAsHtml = function(string) {
        return $sce.trustAsHtml(string);
    };


    $(function() {

        // hamburger menu
        $('#hamburger').click(function(){
            $('body > header nav').toggleClass('expanded');
        });
        $('body > header nav a').click(function(){
            $('body > header nav').removeClass('expanded');
        });


        function onWindowResize() 
        {
            $rootScope.windowHeight = $(window).height();
        }
        onWindowResize();
        $(window).resize(onWindowResize);

    });

    $rootScope.closeMenu = function()
    {
        $('body > header nav').removeClass('expanded');
    }






    // load pages data
    $rootScope.pagesData = [];
    $rootScope.loadPagesData = function()
    {
        $http({
            method  : 'GET',
            url     : config.api.urls.getPages,
            params  : {
                'lang': $rootScope.language
            }
        })
        .then(function(response) {
            $rootScope.pagesData = response.data;
            $rootScope.setMetadata();
        });
    }
    $rootScope.loadPagesData();






    // load proyectos data
    $rootScope.proyectosData = null;
    $rootScope.loadProyectosData = function()
    {
        $http({
            method  : 'GET',
            url     : config.api.urls.getProyectos
        })
        .then(function(response) {
            $rootScope.proyectosData = response.data;
        });
    }
    $rootScope.loadProyectosData();



    // set metadata
    $rootScope.setMetadata = function()
    {
        var pageSlug = $rootScope.pageSlug;
        if (pageSlug == 'home') {
            pageSlug = '.';
        }
        var page = $rootScope.pagesData[pageSlug];

        if (page) {
            document.title = page.meta_title;
            document.querySelector('meta[name=description]').setAttribute('content', page.meta_description);
        }
    }


});

    



