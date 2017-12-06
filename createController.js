app.controller('createController', function($scope, Upload, $rootScope, $http){
	$scope.createCandidate = function(candidate_info, file){
		// get profile type
		// var profile_type = document.getElementById("profile_type");

		// parse info skills checkboxes
		var skills = '';
		if (candidate_info.skills1){
			skills += '1';
		}
		else{
			skills += '0';
		}
		if (candidate_info.skills2){
			skills += '1';
		}
		else{
			skills += '0';
		}
		if (candidate_info.skills3){
			skills += '1';
		}
		else{
			skills += '0';
		}
		
		// make http request to database
		$http({
			url: "create_profile.php",
			method: "POST", 
			data: {'profile_type': $scope.profile_type,
					'new_username': candidate_info.create_u, 
					'new_password': candidate_info.create_p,
					'new_first': candidate_info.create_first,
					'new_last': candidate_info.create_last,
					'new_cloc': candidate_info.create_cloc,
					'new_dloc': candidate_info.create_dloc,
					'new_job': candidate_info.create_job,
					'new_edu': candidate_info.create_edu,
					'new_major': candidate_info.create_major,
					'new_gpa': candidate_info.create_gpa,
					'new_sal': candidate_info.create_sal,
					'new_fun': candidate_info.create_fun,
					'new_skills': skills
					}
			}).then(function(response){
				if (response.data.success === false){
					alert(response.data.message);
				}else{
					alert("you have successfully created a profile!");
					file.upload = Upload.upload({
				      url: 'profile_pic.php',
				      data: {username: candidate_info.username, file: file},
				    });
					file.upload.then(function (response) {
				       alert(response.data.message);
				    });

				}
			});
		}


	$scope.createJob = function(job_info){
		var profile_type = document.getElementById("profile_type");
		var skills = '';
		if (job_info.company_skills1){
			skills += '1';
		}
		else{
			skills += '0';
		}
		if (job_info.company_skills2){
			skills += '1';
		}
		else{
			skills += '0';
		}
		if (job_info.company_skills3){
			skills += '1';
		}
		else{
			skills += '0';
		}

		// make http request to database
		$http({
				url: "create_profile.php",
				method: "POST", 
				data: {'profile_type': $scope.profile_type,
						'new_username': job_info.create_company_u, 
						'new_password': job_info.create_company_p,
						'new_name': job_info.create_company_name,
						'new_loc': job_info.create_company_loc,
						'new_title': job_info.create_title,
						'new_industry': job_info.create_industry,
						'new_sal': job_info.create_company_sal,
						'new_desc': job_info.create_desc,
						'new_skills': skills
						}
				}).then(function(response){
					if (response.data.success === false){
						alert(response.data.message);
					}else{
						alert("you have successfully created a profile!");
					}
				});
		}
});