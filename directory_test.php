<!doctype html>
<html>
<head>
 <meta charset="UTF-8">
 <title>one way data binding</title>
 <body>

<?php
$did = 1;
$base_url = 'http://211.189.20.17:8080/index.php';
$uid = 1;
// change site_url in codeigniter
?>
   <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.9/angular.min.js"></script>
   <script src="directory_core.js"></script>
   <div id="container" ng-app='directory' >
    <div class=".col-sm-6 .col-md-5 .col-lg-6">
      <h4>User Say's</h4><hr>
      <p>
        This is a Demo feed.
      </p>
      <table ng-controller='directoryCtrl' ng-init="init('<?=$did?>','<?=$uid?>','<?=$base_url?>')">
       <thead>
        <tr><th>directory_id : <?=$did?></th></tr>
      </thead>
      <tbody>
        <tr>
         <td>sensor_model : {{sensors.info.sensor_model[sensors.index[1]]}}</td>
         <td>sensor_type : {{sensors.info.sensor_type[sensors.index[1]]}}</td>
         <td>sensor_gid : {{sensors.info.sensor_gid[sensors.index[1]]}}</td>
         <td>recent_data : {{sensors.info.recent_data[sensors.index[1]]}}</td>
       </tr>
        <tr>
         <td>sensor_model : {{sensors.info.sensor_model[sensors.index[2]]}}</td>
         <td>sensor_type : {{sensors.info.sensor_type[sensors.index[2]]}}</td>
         <td>sensor_gid : {{sensors.info.sensor_gid[sensors.index[2]]}}</td>
         <td>recent_data : {{sensors.info.recent_data[sensors.index[2]]}}</td>
       </tr>
        <tr>
         <td>sensor_model : {{sensors.info.sensor_model[sensors.index[3]]}}</td>
         <td>sensor_type : {{sensors.info.sensor_type[sensors.index[3]]}}</td>
         <td>sensor_gid : {{sensors.info.sensor_gid[sensors.index[3]]}}</td>
         <td>recent_data : {{sensors.info.recent_data[sensors.index[3]]}}</td>
       </tr>
        <tr>
         <td>sensor_model : {{sensors.info.sensor_model[sensors.index[10]]}}</td>
         <td>sensor_type : {{sensors.info.sensor_type[sensors.index[10]]}}</td>
         <td>sensor_gid : {{sensors.info.sensor_gid[sensors.index[10]]}}</td>
         <td>recent_data : {{sensors.info.recent_data[sensors.index[10]]}}</td>
       </tr>
     </tbody>
   </table>
       <table ng-controller='dashboardCtrl' ng-init="init('<?=$did?>','<?=$uid?>','<?=$base_url?>')">
       <thead>
       <?php
       $widgets_id = 157;
       ?>
        <tr><th colspan="3">dashboard_id : <?=$uid?> sensor_model : {{widgets.info.sensor_model[widgets.index[<?=$widgets_id?>]]}}</th></tr>
      </thead>
      <tbody >
        <tr>
        <td>sensor_model : {{widgets.info.sensor_model[widgets.index[<?=$widgets_id?>]]}}</td>
         <td>data_date : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_date[0]}}</td>
         <td>data_time : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_time[0]}}</td>
         <td>data_value : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_value[0]}}</td>
       </tr>

         <tr>
         <td>data_date : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_date[1]}}</td>
         <td>data_time : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_time[1]}}</td>
         <td>data_value : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_value[1]}}</td>
       </tr>

         <tr>
         <td>data_date : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_date[2]}}</td>
         <td>data_time : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_time[2]}}</td>
         <td>data_value : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_value[2]}}</td>
       </tr>

         <tr>
         <td>data_date : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_date[3]}}</td>
         <td>data_time : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_time[3]}}</td>
         <td>data_value : {{widgets.data[widgets.index[<?=$widgets_id?>]].data_value[3]}}</td>
       </tr>

     </tbody>
   </table>
 </div>
</div>

</body>
</html>