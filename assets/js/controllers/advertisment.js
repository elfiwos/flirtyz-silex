function Dashboard($scope, $http) {
  //$http.get('api/users').success(function(data) {
   $scope.message = 'This is message dashboard';
 // });
}
function rootLogin($scope, $http) {
$scope.adminName = "abebaw";
}
function Categories($scope, $http) {
  //$http.get('api/users').success(function(data) {
    $scope.message = 'This is message category';
 // });
}


(function (module) {
     
    var fileReader = function ($q, $log) {
 
        var onLoad = function(reader, deferred, scope) {
            return function () {
                scope.$apply(function () {
                    deferred.resolve(reader.result);
                });
            };
        };
 
        var onError = function (reader, deferred, scope) {
            return function () {
                scope.$apply(function () {
                    deferred.reject(reader.result);
                });
            };
        };
 
        
 
        var getReader = function(deferred, scope) {
            var reader = new FileReader();
            reader.onload = onLoad(reader, deferred, scope);
            reader.onerror = onError(reader, deferred, scope);
            return reader;
        };
 
        var readAsDataURL = function (file, scope) {
            var deferred = $q.defer();
             
            var reader = getReader(deferred, scope);         
            reader.readAsDataURL(file);
             
            return deferred.promise;
        };
 
        return {
            readAsDataUrl: readAsDataURL  
        };
    };
 
    module.factory("fileReader",
                   ["$q", "$log", fileReader]);
 
}(angular.module("EmojiApp")));


var UploadController = function ($scope, fileReader, $http) {
    
    $scope.getFile = function () {
       // $scope.progress = 0;
        fileReader.readAsDataUrl($scope.file, $scope)
                      .then(function(result) {
                          $scope.imageSrc = result;
                          $scope.imageName = $scope.file.name;
                          //console.log(result);

                      });
    };

  $scope.save_advertisment = function(){
 fileReader.readAsDataUrl($scope.file, $scope)
                      .then(function(result) {
                          $scope.imageSrc = result;
                          $scope.imageName = $scope.file.name;

                         //  var my_data = new FormData();
                           my_data = {
                                picture:$scope.file,
                                file:result,
                                image:$scope.file.name,
                                description:$scope.ad.description,
                                name:$scope.ad.name,
                                url:$scope.ad.url
                            }



                           // console.log($scope.file);
                          $http.post('/admin/api/web/index.php/api/v1/advertisments', my_data).success(function(data) {
                               console.log(data.message);
                              if(data.message == 0){
                              alert("Advertisment created successfully");
                            }
                            if(data.message == 1){
                              alert("Image size is not correct, the correct image size is 310px - 330px in width and 40px - 60px in height");
                            }
                           });
                      });
                   };


     $scope.update_advertisment = function(index, idx){
      console.log($scope.file);

     var my_data = new Object();

       if(!$scope.file){
         my_data = {
                  description:$scope.advertisment.description,
                  name:$scope.advertisment.name,
                  url:$scope.advertisment.url
                  }
       }else{

 fileReader.readAsDataUrl($scope.file, $scope)
                      .then(function(result) {
                          $scope.imageSrc = result;
                          $scope.imageName = $scope.file.name;
                         
                        
                           


                       });
                       my_data = {
                               // picture:$scope.file,
                                file:$scope.imageSrc,
                                image: $scope.imageName,
                                description:$scope.advertisment.description,
                                name:$scope.advertisment.name,
                                url:$scope.advertisment.url
                            }

  }
   console.log(my_data);                       

                           // console.log($scope.file);
                          $http.put('/admin/api/web/index.php/api/v1/advertisments/' + index, my_data).success(function(data) {
                              console.log(data.message);
                              if(data.message == 0){
                              alert("Advertisment updated successfully");
                            }
                            if(data.message == 1){
                              alert("Image size is not correct, the correct image size is 310px - 330px in width and 40px - 60px in height");
                            }

                           });
                      
                   };

                };

EmojiApp.directive("ngFileSelect",function(){

  return {
    link: function($scope,el){
      
      el.bind("change", function(e){
      
        $scope.file = (e.srcElement || e.target).files[0];
        $scope.getFile();
      })
      
    }
    
  }
  
  
})


EmojiApp.controller("AdvertismentController", ['$scope','$http', function($scope, $http){
$scope.input = {};
$http.get('/admin/api/web/index.php/api/v1/advertisments').success(function(data) {
    console.log(data);
    $scope.advertisments = data;
  });
 $http.get('/admin/api/web/index.php/api/v1/getAllAdClickes').success(function(data) {
     console.log(data);
     $scope.adClicks = data;
 });

  $scope.show_advertisment = function(index, idx) {
      $('#overlay_' + index).addClass('overlay_div');
     // $('.popup_div_orginal').addClass('popup_div');
     $("#popup_" + index).show();
  }

  $scope.cancel_advertisment = function(index, idx) {
      $('#overlay_' + index).removeClass('overlay_div');
     // $('.popup_div_orginal').addClass('popup_div');
     $("#popup_" + index).hide();
  }

/*
$(document).mouseup(function (e)
      {
          var container = $(".popup_div_orginal");
         
          if (!container.is(e.target)
              && container.has(e.target).length === 0) 
          {
              container.hide();
          }
           $('.overlay_div').hide();
      });

*/
    
$scope.deleteAd = function(index, idx) {
    $http.delete('/admin/api/web/index.php/api/v1/advertisments/'+ index).success(function(data) {
      $scope.advertisments.splice(idx, 1);
    console.log(data);
  });
  }

  $scope.checkAll = function () {
        if ($scope.selectedAll) {
            $scope.selectedAll = true;
        } else {
            $scope.selectedAll = false;
        }
        angular.forEach($scope.advertisments, function (advertisment) {
            advertisment.Selected = $scope.selectedAll;

        });

    };

    $scope.deleteSelected = function() {

    angular.forEach($scope.advertisments, function (advertisment, index) {
            if (advertisment.Selected) {
               $http.delete('/admin/api/web/index.php/api/v1/advertisments/'+ advertisment.id).success(function(data) {
               $scope.advertisments.splice(index, 1);
             });
            }
           
        });
  
  }

  }]);