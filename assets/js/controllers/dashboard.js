
EmojiApp.controller("DashboardController", ['$scope','$http', function($scope, $http){
$http.get('/admin/api/web/index.php/api/v1/advertisments').success(function(data) {
    $scope.numberOfAdvertisments = data.length;

  });

$http.get('/admin/api/web/index.php/api/v1/freeEmojis').success(function(data) {
    console.log(data.length);
    $scope.unlockedEmojis = data.length;
  
  });
$http.get('/admin/api/web/index.php/api/v1/paidEmojis').success(function(data) {
    $scope.paidEmojis = data.length;
   console.log(data.length);
  });
$http.get('/admin/api/web/index.php/api/v1/freeCategories').success(function(data) {

    $scope.unlockedCategories = data.length;
  });
$http.get('/admin/api/web/index.php/api/v1/paidCategories').success(function(data) {

    $scope.preminumCategories = data.length;
  });

  }]);

