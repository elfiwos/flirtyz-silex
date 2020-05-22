/*
EmojiApp.controller("FormController", ['$scope','$http', function($scope, $http){
$scope.submit = function() {
    my_data = {
                username:$scope.username,
                password:$scope.password
                  }
  $http.post('/api/web/index.php/api/v1/admin_login_check', my_data).success(function(data) {
    if(data.length > 0){

    }
    });
    };
  }]);


*/

EmojiApp.run(["$rootScope", "$location", function ($rootScope, $location) {

    $rootScope.$on("$routeChangeSuccess", function (userInfo) {
    });

    $rootScope.$on("$routeChangeError", function (event, current, previous, eventObj) {
        if (eventObj.authenticated === false) {
            $location.path("/");
        }
    });
}]);




EmojiApp.factory("authenticationSvc", ["$http","$q","$window",function ($http, $q, $window) {
    var userInfo;
   function login(username, password) {
        var deferred = $q.defer();
           // my_data = {
           //      username:$scope.username,
           //      password:$scope.password
           //  }

        $http.post('/admin/api/web/index.php/api/v1/admin_login_check', { username: username, password: password })
            .then(function (result) {
              if(!result.data[0]){
                $("#username").val('');
                $("#password").val('');
                $window.alert("Invalid credentials");

              }
                userInfo = {

                   // accessToken: result.data.access_token,
                    username: result.data[0].username
                };
                $window.sessionStorage["userInfo"] = JSON.stringify(userInfo);
                deferred.resolve(userInfo);
            }, function (error) {
                deferred.reject(error);
            });

        return deferred.promise;
    }

    function logout() {
        var deferred = $q.defer();

        $http({
            method: "POST",
            url: "/admin/api/web/index.php/api/v1/admin_logout",
            headers: {
                "access_token": userInfo.username
            }
        }).then(function (result) {
            userInfo = null;
            $window.sessionStorage["userInfo"] = null;
            deferred.resolve(result);
        }, function (error) {
            deferred.reject(error);
        });

        return deferred.promise;
    }

    function getUserInfo() {
        return userInfo;
    }

    function init() {
        if ($window.sessionStorage["userInfo"]) {
            userInfo = JSON.parse($window.sessionStorage["userInfo"]);
        }
    }
    init();

    return {
        login: login,
        logout: logout,
        getUserInfo: getUserInfo
    };


}]);

EmojiApp.controller("LoginController", ["$scope", "$location", "$window", "authenticationSvc",function ($scope, $location, $window, authenticationSvc) {
    $scope.userInfo = null;
    $scope.login = function () {

        authenticationSvc.login($scope.username, $scope.password)
            .then(function (result) {
                $scope.userInfo = result;
                $location.path("/dashboard");
            }, function (error) {
                $window.alert("Invalid credentials");
                console.log(error);
            });
    };

}]);



EmojiApp.controller("LogoutController", ["$scope", "$location", "authenticationSvc",function ($scope, $location, authenticationSvc) {
   // $scope.userInfo = null;

    $scope.logout = function () {

        authenticationSvc.logout()
            .then(function (result) {
                $scope.userInfo = null;
                $location.path("/");

            }, function (error) {
                console.log(error);
            });
    };
}]);
