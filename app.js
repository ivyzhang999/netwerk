var app = angular.module('netwerk', ['ngTouch', 'ngRoute', 'ngFileUpload']);

app.run(function($rootScope) {
    $rootScope.profiles = {};
})

app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "main.html"
    })
    .when("/create", {
        templateUrl : "create.html",
        controller: 'createController'
    })
    .when("/edit", {
        templateUrl : "edit.html",
        controller: 'mainController'
    })
    .when("/matches", {
        templateUrl : "matches.html",
        controller: 'mainController'
    })
    .otherwise(({
        redirectTo: '/'
    }));
});
