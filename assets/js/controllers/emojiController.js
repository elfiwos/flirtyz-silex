function EmojiController($scope, $routeParams, $http, fileUpload) {

	$scope.categories;
  $scope.emojis;
	$scope.category = {};
	$scope.category.version = '';
	$scope.category.name = '';
  $scope.input = {};
  $http.get('/admin/api/web/index.php/api/v1/emojiCategories').success(function(data){
    $scope.categories = data;
  });

  if($routeParams !== undefined){
    $http.get('/admin/api/web/index.php/api/v1/emojiCategories/'+$routeParams.id).success(function(data){
    $scope.category = data[0];
    $http.get('/admin/api/web/index.php/api/v1/emojis/'+$routeParams.id).success(function(emojis){
      $scope.emojis = emojis;
      $scope.selectme = $scope.categories[0];
      for(var i=0; i<$scope.categories.length;i++){

        if($scope.categories[i].id == $scope.category.id){
          $scope.defaultCategory = $scope.categories[i];
          break;
        }

        
      }

    });
  });
  } 


  
 
  $scope.saveEmoji = function(emoji){
    // console.log(emoji);
    var file = $scope.emoji.myFile;
        console.log('file is ' + JSON.stringify(file));
    var uploadUrl = "/admin/api/web/index.php/api/v1/emoji-uploads/";
    fileUpload.uploadFileToUrl(file, uploadUrl);
    

    emoji.category_id = $scope.defaultCategory.id;
    $http.post('/admin/api/web/index.php/api/v1/emojis', {name: emoji.name, image: $scope.emoji.myFile.name, category_id:emoji.category_id }).
  success(function(data, status, headers, config) {
    $scope.emoji = {};
     $('#emojiPreview').attr("src", 'assets/images/partials/actual-advertisment.png');
      $('#popup').removeClass('popup');
      $('#overlay').removeClass('overlay');
    $http.get('/admin/api/web/index.php/api/v1/emojis/'+$routeParams.id).success(function(emojis){
      console.log(emojis);
      $scope.emojis = emojis;
    });
    alert('Emoji Created Successfully.');
  }).
  error(function(data, status, headers, config) {
    // console.log(data);
  });
  }
  $scope.deleteCategories = function(){
    angular.forEach($scope.categories, function (categories, index) {
            if ($scope.categories.checkAll || categories.selected) {
               $http.delete('/admin/api/web/index.php/api/v1/emojiCategories/'+ categories.id).success(function(data) {
               $scope.categories.splice(index, 1);
             });
            }
           
        });
  }

	$scope.deleteCategory = function(category, index){
		$http.delete('/admin/api/web/index.php/api/v1/emojiCategories/'+category,{}).success(function(data, status, headers, config) {
  	$scope.categories.splice(index, 1);

    alert('Category Deleted Successfully.');
  }).
  error(function(data, status, headers, config) {
    // console.log(data);
  });
		
	}

  $scope.deleteEmojis = function(emoji, index){
    angular.forEach($scope.emojis, function (emoji, index) {
            if ($scope.checkAll || emoji.selected) {
               $http.delete('/admin/api/web/index.php/api/v1/emojis/'+ emoji.id).success(function(data) {
               $scope.emojis.splice(index, 1);
             });
            }
           
        });
  }

    $scope.saveCategory = function(category){

    	var file = $scope.category.myFile;
        console.log('file is ' + JSON.stringify(file));
        var uploadUrl = "/admin/api/web/index.php/api/v1/emoji-uploads/";
        fileUpload.uploadFileToUrl(file, uploadUrl);
        if(category !== undefined){
        	category.image = $scope.category.myFile.name;
	    	$http.put('/admin/api/web/index.php/api/v1/emojiCategories/'+category.id, category).
  success(function(data, status, headers, config) {
    // $scope.category = {};
    alert('Category Updated Successfully.');
  }).
  error(function(data, status, headers, config) {
    // console.log(data);
  });
	    	return false;
    	}

    	$http.post('/admin/api/web/index.php/api/v1/emojiCategories', {version: $scope.category.version, name: $scope.category.name, image: $scope.category.myFile.name}).
  success(function(data, status, headers, config) {
  	// document.getElementById('categoryImagePreview').src = "assets/images/partials/actual-advertisment.png";
    // $scope.category = {};
    alert('Category Created Successfully.');
  }).
  error(function(data, status, headers, config) {
    // console.log(data);
  });
    }

    $('#showPopup').click(function(e){
      $('#overlay').addClass('overlay');
      $('#popup').addClass('popup');
    });

    $('#closePopup').click(function(e){
      $('#overlay').removeClass('overlay');
      $('#popup').removeClass('popup');
    });
}

function readURL(input, id) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#categoryImagePreview, #categoryImagePreview-'+id + ", #emojiPreview").attr('src', e.target.result);
            
        }
        reader.readAsDataURL(input.files[0]);
    }
}

