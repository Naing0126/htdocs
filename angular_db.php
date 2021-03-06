<!doctype html>
<html>
<head>
 <meta charset="UTF-8">
 <title>one way data binding</title>
 <body>

   <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.9/angular.min.js"></script>
   <script src="core.js"></script>
   <div id="container" ng-app='two_way' ng-controller='two_way_control'>
    <div class=".col-sm-6 .col-md-5 .col-lg-6">
      <h4>User Say's</h4><hr>
      <p>
        This is a Demo feed. It is developed to demonstrate Two way data binding.
      </p>
      <table>
       <thead>
        <tr><th>directory_name</th></tr>
      </thead>
      <tbody>
        <tr ng-repeat="data in directories">
        <?php
          if('{{data.did>2}}'==='true'){
        ?>
         <td>{{data.directory_name}}</td>
         <?php
       }
         ?>

       </tr>
     </tbody>
   </table>
     <table>
       <thead>
        <tr><th>sensor_name</th></tr>
      </thead>
      <tbody>
        <tr ng-repeat="sensor in sensors">
         <td>{{sensor.sensor_model}}</td>
       </tr>
     </tbody>
   </table>
 </div>
</div>

</body>
</html>