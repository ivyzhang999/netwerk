var app = angular.module('netwerk', ['ngTouch', 'ngRoute', 'ngFileUpload']);

// app.config(function($routeProvider) {
//     $routeProvider
//     .when("/", {
//         templateUrl : "main.html"
//     })
//     .when("/create", {
//         templateUrl : "create.html"
//     })
//     .when("/edit", {
//         templateUrl : "edit.html"
//     })
//     .when("/matches", {
//         templateUrl : "matches.html"
//     })
//     .otherwise(({
//         redirectTo: '/'
//     }));
// });

app.run(function($rootScope) {
    $rootScope.profiles = {};
})

app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "index3.html"
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

// var profiles = function($http) {
//   return {
//     getJobs: function () {
//       $http.post("jobs_mysql.php").then(function(response){
// 					return response.data.jobs;
// 				});
//     },
//     getCandidates: function () {
//       $http.post("candidates_mysql.php").then(function(response){
// 					return response.data.candidates;
// 				});
//     }
//   };
// }
// app.factory('profiles', function($http) {
//   return {
// 	    getJobs: function () {
// 	      $http.post("jobs_mysql.php").then(function(response){
// 						return response.data.jobs;
// 					});
// 	    },
// 	    getCandidates: function () {
// 	      $http.post("candidates_mysql.php").then(function(response){
// 						return response.data.candidates;
// 					});
// 	    }
// 	}	
// });