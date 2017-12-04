var app = angular.module('netwerk', ['ngTouch']);

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