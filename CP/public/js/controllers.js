'use strict';


function IndexCtrl($scope, $http) {
  $http.get('/api/posts').
    success(function(data, status, headers, config) {
      $scope.posts = data.posts;
    });
}

function AddPostCtrl($scope, $http, $location) {
  // $scope.form = {};
  $scope.submitPost = function () {
    $http.post('/api/post', $scope.form).
      success(function(data) {
        $location.path('/');
      });
  };
}

function CommentCtrl($scope, $http, $routeParams) {
  $http.get('/api/post/'+ $routeParams.id + '/comments').
    success(function(data) {
      $scope.post = data.post;
    });
    
  $scope.submitComment = function() {
    $http.post('/api/post/' + $routeParams.id + '/comments', $scope.form).
      success(function(data) {
        $location.path('/post/' + $routeParams.id + '/comments');
      });
  };
}

function EditPostCtrl($scope, $http, $location, $routeParams) {
  $scope.form = {};
  $http.get('/api/post/' + $routeParams.id).
    success(function(data) {
      $scope.form = data.post;
    });

  $scope.editPost = function () {
    $http.put('/api/post/' + $routeParams.id, $scope.form).
      success(function(data) {
        $location.url('/');
      });
  };
}

function EditCommentCtrl($scope, $http, $location, $routeParams) {
  $scope.form = {};
  $http.get('/api/post/' + $routeParams.id + '/editComments/' + $routeParams.cid).
    success(function(data) {
      $scope.form = data.post;
    });

  $scope.editComment = function () {
    $http.put('/api/post/' + $routeParams.id, $scope.form).
      success(function(data) {
        $location.url('/post/' + $routeParams.id + '/comments');
      });
  };
}

function DeletePostCtrl($scope, $http, $location, $routeParams) {
  $http.get('/api/post/' + $routeParams.id).
    success(function(data) {
      $scope.post = data.post;
    });

  $scope.deletePost = function () {
    $http.delete('/api/post/' + $routeParams.id).
      success(function(data) {
        $location.url('/');
      });
  };

  $scope.home = function () {
    $location.url('/');
  };
}

function DeleteCommentCtrl($scope, $http, $location, $routeParams) {
  $http.get('/api/post/' + $routeParams.id).
    success(function(data) {
      $scope.post = data.post;
    });

  $scope.deleteComment = function () {
    $http.delete('/api/post/' + $routeParams.id + '/deleteComment/' + $routeParams.cid).
      success(function(data) {
        $location.url('/api/post/' + $routeParams.id);
      });
  };

  $scope.home = function () {
    $location.url('/post/' + $routeParams.id + '/comments');
  };

}