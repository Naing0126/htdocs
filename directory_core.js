var app=angular.module('directory',[]);
app.controller('directoryCtrl',function($scope,$http,$interval){

    $scope.init = function(did,uid,url){
           load_included_sensors_in_directory(did,url);
    $interval(function(){
        load_included_sensors_in_directory(did,url);
    },300);
    }

    function load_included_sensors_in_directory(did,url){
        $http.get(url+'/dashboard/get_included_sensors_in_directory/'+did).success(function(data){
            $scope.sensors=data;
        });

    };
});

app.controller('dashboardCtrl',function($scope,$http,$interval){

    $scope.init = function(did,uid,url){
            load_included_sensors_in_dashboard(uid,url);
    $interval(function(){
         load_included_sensors_in_dashboard(uid,url);
    },300);
    }

    function load_included_sensors_in_dashboard(uid,url){
          $http.get('http://211.189.20.17:8080/index.php/dashboard/get_included_sensors_in_dashboard/'+uid).success(function(data){
            $scope.widgets=data;
        });
    };
});