var app=angular.module('angular',[]);
app.controller('directoryCtrl',function($scope,$http,$interval){

    $scope.init = function(did,url){
     load_included_sensors_in_directory(did,url);
     $interval(function(){
        load_included_sensors_in_directory(did,url);
    },5000);
 }

 function load_included_sensors_in_directory(did,url){
    $http.get(url+'/dashboard/get_included_sensors_in_directory/'+did).success(function(data){
        $scope.sensors=data;
    });

};
});

app.controller('dashboardCtrl',function($scope,$http,$interval){

    $scope.init = function(uid,url){
        load_included_sensors_in_dashboard(uid,url);
        $interval(function(){
           load_included_sensors_in_dashboard(uid,url);
       },5000);
    }

    function load_included_sensors_in_dashboard(uid,url){
      $http.get(url+'/dashboard/get_included_sensors_in_dashboard/'+uid).success(function(data){
        $scope.widgets=data;
    });
  };

  $scope.labels = ["January", "February", "March", "April", "May", "June", "July"];
  $scope.series = ['Series A', 'Series B'];
  $scope.data = [
  [65, 59, 80, 81, 56, 55, 40],
  [28, 48, 40, 19, 86, 27, 90]
  ];
  $scope.onClick = function (points, evt) {
    console.log(points, evt);
};
});