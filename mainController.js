app.factory('profilesFactory', function($http) {
	var profiles = {};	
	profiles.getJobs = function(){
		return $http.post("jobs_mysql.php");
	}
	profiles.getCandidates = function(){
		return $http.post("candidates_mysql.php");
	}
	return profiles;
});

app.controller('mainController', function($scope, $http, profilesFactory){
	var getProfiles = function(){

		if ($scope.current_user !== ""){
			if ($scope.profile_type === "candidate"){
					profilesFactory.getJobs().then(function(response){
					$scope.profiles = response.data.jobs;
				});

			}
			else{
				profilesFactory.getCandidates().then(function(response){
					$scope.profiles = response.data.candidates;
				});
			}	
		}
	}


	// switch to next profile and save the input (if its a like)
	$scope.swipeRight = function(){
		$http({
				url: "like.php",
				method: "POST",
				data: {
					"liker": $scope.current_user,
					"liked": $scope.profiles[$scope.index].username
				}
			}).then(function(response){
				if (response.data.success === false){
					alert(response.data.message);
				}
			});
		
		// update list of matches
		showMatches();
		
		// switch to next profile
		$scope.index = $scope.index + 1;
		if ($scope.index + 1 > $scope.profiles.length ){
			alert("no profiles left to swipe");
		}
	}

	// switch to next profile
	$scope.swipeLeft = function(){
		$scope.index = $scope.index + 1;
		if ($scope.index + 1 > $scope.profiles.length ){
			alert("no profiles left to swipe");
		}
	}

	var showMatches = function(){
		//alert($scope.matches);
		if ($scope.current_user !== ""){
			$http({
				url: "show_matches.php",
				method: "POST"
			}).then(function(response){
				if (response.data.success === false){
					alert(response.data.message);
				}else{

					if ($scope.matchCount !== -1){
					 	var matches = response.data.matches;
						var new_len = Object.keys(matches).length
						if (new_len > $scope.matchCount){
							alert("You have a new match");
						}
					}

					$scope.matches = response.data.matches;
					$scope.matchCount = Object.keys($scope.matches).length;

					var matches_temp = $scope.matches;
					var profiles_len = Object.keys($scope.profiles).length;
					$scope.matches_info = [];
					
					
					if ($scope.profile_type === "job"){
						for (var i = 0; i < profiles_len; i++){
							if (matches_temp.indexOf($scope.profiles[i].username) !== -1){
								var matchholder = $scope.profiles[i].first_name + 
								" " + $scope.profiles[i].last_name + " - " + $scope.profiles[i].education;
								$scope.matches_info.push(matchholder);
							}
						}
					} else {
						for (var i = 0; i < profiles_len; i++){
							if (matches_temp.indexOf($scope.profiles[i].username) !== -1){
								var matchholder = $scope.profiles[i].company_name + " - " + $scope.profiles[i].title;
								$scope.matches_info.push(matchholder);
							}
						}
					}
				}
			});
		}
	}

	$scope.login = function(login){
		if ($scope.current_user === undefined || $scope.current_user === ""){
			$http({
			url: "login.php",
			method: "POST", 
			data: {'profile_type': login.profile_type,
					'username': login.username, 
					'password': login.password
					}
			}).then(function(response){
				if (response.data.success === false){
					alert(response.data.message);
				}else{
					$scope.profile_type = login.profile_type;
					$scope.current_user = login.username;
					$scope.matchCount = -1;
					alert("login success!");
					getProfiles();
					showMatches();
					$scope.index = 0;
				}
			});
			
		}
		else{
			alert("Please logout first");
		}	
	}

	$scope.logout = function(){
		if ($scope.current_user !== ""){
			$http({
				url: "logout.php",
				method: "POST"
				}).then(function(response){
						alert("logout success!");
						$scope.profiles = "";
						$scope.matches = "";
						$scope.current_user = "";
			});
		}else{
			alert("there is no user logged in")
		}
		
	}
	
	$scope.like = function(profile){
		$http({
			url: "like.php",
			method: "POST", 
			data: {"liker": $scope.current_user,
				"liked": profile.username}
			}).then(function(response){
				
			});
	}
	
});

