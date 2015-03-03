var app=angular.module('two_way',[]);
app.controller('two_way_control',function($scope,$http,$interval){
    load_pictures();
    $interval(function(){
        load_pictures();
    },300);
    function load_pictures(){
        $http.get('http://211.189.20.17:8080/index.php/dashboard/get_directories_by_did/1').success(function(data){
            $scope.directories=data;
        });
          $http.get('http://211.189.20.17:8080/index.php/dashboard/get_sensors/1').success(function(data){
            $scope.sensors=data;
        });
    };
});