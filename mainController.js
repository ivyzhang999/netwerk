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

app.controller('mainController', function($scope, $rootScope, $http, profilesFactory){
	var getProfiles = function(){

		if ($rootScope.current_user !== ""){
			if ($rootScope.profile_type === "candidate"){
					profilesFactory.getJobs().then(function(response){
					$rootScope.profiles = response.data.jobs;
				});

			}
			else{
				profilesFactory.getCandidates().then(function(response){
					$rootScope.profiles = response.data.candidates;
				});
			}	
		}
	}


	// switch to next profile and save the input (if its a like)
	$scope.swipeRight = function(){
		var audio = new Audio('Swish-sound-effect.mp3');
		audio.play();
		$http({
				url: "like.php",
				method: "POST",
				data: {
					"liker": $rootScope.current_user,
					"liked": $rootScope.profiles[$rootScope.index].username
				}
			}).then(function(response){
				if (response.data.success === false){
					alert(response.data.message);
				}
			});
		
		// update list of matches
		showMatches();
		
		// switch to next profile
		$rootScope.index = $rootScope.index + 1;
		if ($rootScope.index + 1 > $rootScope.profiles.length ){
			alert("no profiles left to swipe");
		}
	}

	// switch to next profile
	$scope.swipeLeft = function(){
		var audio = new Audio('fail-trombone-01.mp3');
		audio.play();
		$rootScope.index = $rootScope.index + 1;
		if ($rootScope.index + 1 > $rootScope.profiles.length ){
			alert("no profiles left to swipe");
		}
	}

	var showMatches = function(){
		//alert($rootScope.matches);
		if ($rootScope.current_user !== ""){
			$http({
				url: "show_matches.php",
				method: "POST"
			}).then(function(response){
				if (response.data.success === false){
					alert(response.data.message);
				}else{
					// alert when you have a new match
					if ($rootScope.matchCount !== -1){
					 	var matches = response.data.matches;
						var new_len = Object.keys(matches).length
						if (new_len > $rootScope.matchCount){
							var audio = new Audio('Good-idea-bell.mp3');
							audio.play();
							alert("You have a new match");
						}
					}

					$rootScope.matches = response.data.matches;
					$rootScope.matchCount = Object.keys($rootScope.matches).length;

					var matches_temp = $rootScope.matches;
					var profiles_len = Object.keys($rootScope.profiles).length;
					$rootScope.matches_info = [];
					
					
					if ($rootScope.profile_type === "job"){
						for (var i = 0; i < profiles_len; i++){
							if (matches_temp.indexOf($rootScope.profiles[i].username) !== -1){
								var matchholder = $rootScope.profiles[i].first_name + 
								" " + $rootScope.profiles[i].last_name + " - " + $rootScope.profiles[i].education;
								$rootScope.matches_info.push(matchholder);
							}
						}
					} else {
						for (var i = 0; i < profiles_len; i++){
							if (matches_temp.indexOf($rootScope.profiles[i].username) !== -1){
								var matchholder = $rootScope.profiles[i].company_name + " - " + $rootScope.profiles[i].title;
								$rootScope.matches_info.push(matchholder);
							}
						}
					}
				}
			});
		}
	}

	var getSuggestion = function(location){
		$http({
			url: "suggestion.php",
			method: "POST", 
			data: {'location': location}
			}).then(function(response){
				$rootScope.suggestion= response.data.suggestion;
			});

	}

	var assessSkills = function(skills){
		$rootScope.headerBool = 0;
		$rootScope.skills1Bool = 0;
		$rootScope.skills2Bool = 0;
		$rootScope.skills3Bool = 0;
		if ($rootScope.profile_type === "candidate"){
			if (skills[0] === "0"){
				$rootScope.headerBool = 1;
				$rootScope.skills1Bool = 1;
			}
			if (skills[1] === "0"){
				$rootScope.headerBool = 1;
				$rootScope.skills2Bool = 1;
			}
			if (skills[2] === "0"){
				$rootScope.headerBool = 1;
				$rootScope.skills3Bool = 1;
			}
		}
	}

	$scope.login = function(login){
		if ($rootScope.current_user === undefined || $rootScope.current_user === ""){
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
					$rootScope.profile_type = login.profile_type;
					$rootScope.current_user = login.username;
					$rootScope.matchCount = -1;
					alert("login success!");
					getProfiles();
					showMatches();
					$rootScope.index = 0;
					$rootScope.logBool = 1;
					$rootScope.current_profile = response.data;
					getSuggestion(response.data.location);
					var skills = response.data.skills;
					assessSkills(skills);
					
				}
			});
			
		}
		else{
			alert("Please logout first");
		}	
	}

	$scope.logout = function(){
		if ($rootScope.current_user !== ""){
			$http({
				url: "logout.php",
				method: "POST"
				}).then(function(response){
						alert("logout success!");
						$rootScope.profiles = "";
						$rootScope.matches = "";
						$rootScope.matches_info = "";
						$rootScope.current_user = "";
						$rootScope.logBool = 0;
						$rootScope.profile_type = login.profile_type;
						$rootScope.headerBool = 0;
						$rootScope.skills1Bool = 0;
						$rootScope.skills2Bool = 0;
						$rootScope.skills3Bool = 0;
			});
		}else{
			alert("there is no user logged in")
		}
		
	}
	
	$scope.like = function(profile){
		$http({
			url: "like.php",
			method: "POST", 
			data: {"liker": $rootScope.current_user,
				"liked": profile.username}
			}).then(function(response){
				
			});
	}
	
	$scope.editCandidate = function(candidate_info){
		// parse info skills checkboxes
		var skills = '';
		if (candidate_info.edit_skills1){
			skills += '1';
		}
		else{
			skills += '0';
		}
		if (candidate_info.edit_skills2){
			skills += '1';
		}
		else{
			skills += '0';
		}
		if (candidate_info.edit_skills3){
			skills += '1';
		}
		else{
			skills += '0';
		}
		
		// make http request to database
		$http({
			url: "edit_profile.php",
			method: "POST", 
			data: {'profile_type': $rootScope.profile_type,
					'username': $rootScope.current_user,
					'password': candidate_info.edit_p, 
					'first': candidate_info.edit_first,
					'last': candidate_info.edit_last,
					'cloc': candidate_info.edit_cloc,
					'dloc': candidate_info.edit_dloc,
					'job': candidate_info.edit_job,
					'edu': candidate_info.edit_edu,
					'major': candidate_info.edit_major,
					'gpa': candidate_info.edit_gpa,
					'sal': candidate_info.edit_sal,
					'fun': candidate_info.edit_fun,
					'skills': skills
					}
			}).then(function(response){
				if (response.data.success === false){
					alert(response.data.message);
				}else{
					alert("you have successfully edited your profile!");
					$rootScope.current_profile = response.data;
					assessSkills(skills);
				}
			});
		}


	$scope.editJob = function(job_info){
		var skills = '';
		if (job_info.edit_company_skills1){
			skills += '1';
		}
		else{
			skills += '0';
		}
		if (job_info.edit_company_skills2){
			skills += '1';
		}
		else{
			skills += '0';
		}
		if (job_info.edit_company_skills3){
			skills += '1';
		}
		else{
			skills += '0';
		}

		// make http request to database
		$http({
				url: "edit_profile.php",
				method: "POST", 
				data: {'profile_type': $rootScope.profile_type,
						'username': $rootScope.current_user, 
						'password': job_info.edit_company_p,
						'name': job_info.edit_company_name,
						'loc': job_info.edit_company_loc,
						'title': job_info.edit_title,
						'industry': job_info.edit_industry,
						'sal': job_info.edit_company_sal,
						'desc': job_info.edit_desc,
						'skills': skills
						}
				}).then(function(response){
					if (response.data.success === false){
						alert(response.data.message);
					}else{
						alert("you have successfully edited your profile!");
						$rootScope.current_profile = response.data;
					}
				});
		}


});

