var EmojiApp =  angular.module('EmojiApp', []);

  EmojiApp.config(['$routeProvider', function($routeProvider) {
  $routeProvider.
      when('/', {templateUrl: 'partials/login.html', controller: rootLogin}).
      
      when('/dashboard', {templateUrl: 'partials/dashboard.html', controller: Dashboard,
        resolve: {
            auth: function ($q, authenticationSvc) {
                var userInfo = authenticationSvc.getUserInfo();
                console.log(userInfo);
                if (userInfo) {
                    return $q.when(userInfo);
                } else {
                    return $q.reject({ authenticated: false });
                }
            }
        }
    }).
      when('/categories', {templateUrl: 'partials/categories.html', controller: EmojiController,
    resolve: {
            auth: function ($q, authenticationSvc) {
                var userInfo = authenticationSvc.getUserInfo();
                if (userInfo) {
                    return $q.when(userInfo);
                } else {
                    return $q.reject({ authenticated: false });
                }
            }
        }
      }).
      when('/category/:id', {templateUrl: 'partials/category.html', controller: EmojiController,
    resolve: {
            auth: function ($q, authenticationSvc) {
                var userInfo = authenticationSvc.getUserInfo();
                if (userInfo) {
                    return $q.when(userInfo);
                } else {
                    return $q.reject({ authenticated: false });
                }
            }
        }
      }).
      when('/emoji-listings/:id', {templateUrl: 'partials/emoji_listing.html', controller: EmojiController,
    resolve: {
            auth: function ($q, authenticationSvc) {
                var userInfo = authenticationSvc.getUserInfo();
                if (userInfo) {
                    return $q.when(userInfo);
                } else {
                    return $q.reject({ authenticated: false });
                }
            }
        }
      }).
      when('/emojis', {templateUrl: 'partials/emojis_list.html', controller: EmojiController,
        resolve: {
            auth: function ($q, authenticationSvc) {
                var userInfo = authenticationSvc.getUserInfo();
                if (userInfo) {
                    return $q.when(userInfo);
                } else {
                    return $q.reject({ authenticated: false });
                }
            }
        }
    }).
      when('/advertisments', {templateUrl: 'partials/advertisment.html', controller: EmojiController,
       resolve: {
            auth: function ($q, authenticationSvc) {
                var userInfo = authenticationSvc.getUserInfo();
                if (userInfo) {
                    return $q.when(userInfo);
                } else {
                    return $q.reject({ authenticated: false });
                }
            }
        }
    }).
      when('/ad_analytics', {templateUrl: 'partials/ad_analytics.html', controller: EmojiController,
          resolve: {
              auth: function ($q, authenticationSvc) {
                  var userInfo = authenticationSvc.getUserInfo();
                  if (userInfo) {
                      return $q.when(userInfo);
                  } else {
                      return $q.reject({ authenticated: false });
                  }
              }
          }
      }).
      when('/create_categories', {templateUrl: 'partials/create_categories.html', controller: Categories,
     resolve: {
            auth: function ($q, authenticationSvc) {
                var userInfo = authenticationSvc.getUserInfo();
                if (userInfo) {
                    return $q.when(userInfo);
                } else {
                    return $q.reject({ authenticated: false });
                }
            }
        }
    }).
      when('/create_advertisment', {templateUrl: 'partials/create_advertisment.html', controller: UploadController,
     resolve: {
            auth: function ($q, authenticationSvc) {
                var userInfo = authenticationSvc.getUserInfo();
                if (userInfo) {
                    return $q.when(userInfo);
                } else {
                    return $q.reject({ authenticated: false });
                }
            }
        }
    }).

      otherwise({redirectTo: '/'});
}]);

EmojiApp.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            
            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);

EmojiApp.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function(data){
          console.log(data);
        })
        .error(function(data){
          console.log(data);
        });
    }
}]);








