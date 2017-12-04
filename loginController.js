app.controller('loginController', function($scope, $http){
	$scope.showProfiles = function(){
		var current_user = document.getElementById("current_user").value;
		if (typeof(current_user) !== "undefined"){
			alert("hello!");
			$http.post("candidates_mysql.php").then(function(response){
			// if (response.data.success){
			// 	$scope.names = response.data.message;
			// }
			// else{
			// 	$scope.names = response.data.message;
			// }
			$scope.names = response.data.message;
			});
			// $scope.names = candidateFactory.getCandidates();
		}
	}

	$scope.login = function(login){
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
					document.getElementById('current_user').value=response.data.user;
					alert("login success!");
					$scope.showProfiles();
				}
			});
	}

	
});